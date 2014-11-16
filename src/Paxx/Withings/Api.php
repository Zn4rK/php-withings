<?php

namespace Paxx\Withings;

use Guzzle\Http\Client as GuzzleClient;
use Paxx\Withings\Exception\ApiException;
use Paxx\Withings\Exception\WbsException;
use Paxx\Withings\Oauth\OauthPlugin;

class Api
{
    const ENDPOINT = 'http://wbsapi.withings.net';

    private $consumer_key;
    private $consumer_secret;
    private $access_token;
    private $token_secret;
    private $user_id;

    private $client;

    private $required_params = array(
        'consumer_key',
        'consumer_secret',
        'access_token',
        'token_secret',
        'user_id'
    );

    private $errors = array(
        0    => 'Operation was successful',
        247  => 'The user_id provided is absent, or incorrect',
        250  => 'The provided user_id and/or Oauth credentials do not match',
        286  => 'No such subscription was found',
        293  => 'The callback URL is either absent or incorrect',
        294  => 'No such subscription could be deleted',
        304  => 'The comment is either absent or incorrect',
        305  => 'Too many notifications are already set',
        342  => 'The signature (using Oauth) is invalid',
        343  => 'Wrong Notification Callback Url doesn\'t exist',
        601  => 'Too Many Requests',
        2554 => 'Unspecified unknown error occurred',
        2555 => 'An unknown error occurred'
    );

    public function __construct(array $params = array())
    {
        $this->hydrateParams($params);

        $config = array(
            'consumer_key'    => $this->consumer_key,
            'consumer_secret' => $this->consumer_secret,
            'token'           => $this->access_token,
            'token_secret'    => $this->token_secret
        );

        $this->client = new GuzzleClient(self::ENDPOINT);
        $this->client->addSubscriber(new OauthPlugin($config));
    }

    private function validateParams(array $params)
    {
        foreach ($this->required_params as $param) {
            if (! isset($params{$param})) {
                throw new ApiException('Missing parameters');
            }
        }
    }

    private function hydrateParams(array $params)
    {
        $this->validateParams($params);

        foreach ($this->required_params as $param) {
            $this->{$param} = $params[$param];
        }
    }

    private function request($service = '', $action = '', $params = array(), $method = 'GET')
    {
        // Set the user_id
        $params['userid'] = $this->user_id;

        // action is just a querystring
        if (! empty($action)) {
            $params['action'] = $action;
        }

        // Build a request
        $request = $this->client->get($service);

        // Params will almost never be empty, but we'll do it like this;
        $query = $request->getQuery();

        foreach ($params as $key => $val) {
            $query->set($key, $val);
        }

        // Decode the response
        $response = json_decode($request->send()->getBody(true), true);

        if ($response['status'] !== 0) {
            if (isset($this->errors[$response['status']])) {
                throw new WbsException($this->errors[$response['status']], $response['status']);
            }
        }

        // Check
        if (isset($response['body'])) {
            return $response['body'];
        }

        // We'll return true if nothing else has happened...
        return true;
    }

    public function getUser()
    {
        $user = $this->request('user', 'getbyuserid');

        // Pluck single record
        $user = end($user['users']);

        return new Collection\User($user);
    }

    /**
     * Get user's activity
     *
     * @param array $params        Array of params. Requires 'date' OR 'startdateymd' and 'enddateymd', all formatted YYYY-mm-dd
     * @return Collection\Activity
     * @throws ApiException        If a valid set of data parameters isn't sent along
     * @throws WbsException        If an error is returned from the API
     */
    public function getActivity(array $params = array())
    {
        // Check date is present and not empty
        if (isset($params['date'])) {
            if (! empty($params['date'])) {
                $activity = $this->request('v2/measure', 'getactivity', ['date' => $params['date']]);
            } else {
                throw new ApiException('Parameter "date" can\'t be empty');
            }
        }
        // If we don't get a date but a range
        elseif (isset($params['startdateymd']) && ! empty($params['startdateymd'])) {
            // Making sure there's an end date
            if (! isset($params['enddateymd'])) {
                throw new ApiException('You need to enter a start and end date.');
            } else {
                $activity = $this->request('v2/measure', 'getactivity', ['startdateymd' => $params['startdateymd'], 'enddateymd' => $params['enddateymd']]);
            }
        }
        // If we don't get any parameters sent
        else {
            throw new ApiException('You need to pass either a date or a range of dates.');
        }

        return new Collection\Activity($activity);
    }

    public function getMeasures(array $params = array())
    {
        // Returns Measure
        $measure = $this->request('measure', 'getmeas', $params);

        return new Collection\Measure($measure);
    }

    public function subscribe($callback = '', $comment = '', $appli = 1)
    {
        if (empty($callback)) {
            throw new ApiException('First parameter "callback" can\'t be empty');
        }

        if (empty($comment)) {
            throw new ApiException('Second parameter "comment" can\'t be empty');
        }

        $params = array(
            'callbackurl' => $callback,
            'comment'     => $comment,
            'appli'       => $appli
        );

        // Add a subscription
        $subscribe = $this->request('notify', 'subscribe', $params);
        return $subscribe;
    }

    public function unsubscribe($callback = '', $appli = 1)
    {
        if (empty($callback)) {
            throw new ApiException('First parameter "callback" can\'t be empty');
        }

        $params = array(
            'callbackurl' => $callback,
            'appli'       => $appli
        );

        // Revoke subscription
        $unsubscribe = $this->request('notify', 'revoke', $params);
        return $unsubscribe;
    }

    public function listSubscriptions($appli = 1)
    {
        $list = $this->request('notify', 'list', array('appli' => $appli));
        return new Collection\SubscriptionList($list);
    }

    public function isSubscribed($callback = '', $appli = 1)
    {
        if (empty($callback)) {
            throw new ApiException('First parameter "callback" can\'t be empty');
        }

        $params = array(
            'callbackurl' => $callback,
            'appli'       => $appli
        );

        $isSubscribed = $this->request('notify', 'get', $params);
        return new Collection\Subscription($isSubscribed);
    }
}
