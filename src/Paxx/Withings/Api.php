<?php

namespace Paxx\Withings;

use \Guzzle\Http\Client as GuzzleClient;
use Paxx\Withings\Oauth\OauthPlugin;
use Paxx\Withings\Exception\ApiException;
use Paxx\Withings\Exception\WbsException;

class Api
{
    const ENDPOINT = 'http://wbsapi.withings.net';

    private $signature_method;

    private $consumer_key;
    private $consumer_secret;
    private $access_token;
    private $token_secret;
    private $user_id;

    private $client;

    private $errors = array(
        0    => 'Operation was successful',
        247  => 'The userid provided is absent, or incorrect',
        250  => 'The provided userid and/or Oauth credentials do not match',
        286  => 'No such subscription was found',
        293  => 'The callback URL is either absent or incorrect',
        294  => 'No such subscription could be deleted',
        304  => 'The comment is either absent or incorrect',
        305  => 'Too many notifications are already set',
        342  => 'The signature (using Oauth) is invalid',
        343  => 'Wrong Notification Callback Url don\'t exist',
        601  => 'Too Many Requests',
        2554 => 'Unspecifed unknown error occured',
        2555 => 'An unknown error occurred'
    );

    public function __construct(array $params = array()) {
    	isset($params['consumer_key']) 	  and $this->consumer_key    = $params['consumer_key'];
    	isset($params['consumer_secret']) and $this->consumer_secret = $params['consumer_secret'];
    	isset($params['access_token'])    and $this->access_token    = $params['access_token'];
        isset($params['token_secret'])    and $this->token_secret    = $params['token_secret'];
        isset($params['user_id'])         and $this->user_id         = $params['user_id'];
   
        if(isset(
            $this->consumer_key,
            $this->consumer_secret,
            $this->access_token, 
            $this->token_secret,
            $this->user_id
        )) {
            $config = array(
                'consumer_key'    => $this->consumer_key,
                'consumer_secret' => $this->consumer_secret,
                'token'           => $this->access_token,
                'token_secret'    => $this->token_secret
            );

            $this->client = new GuzzleClient(self::ENDPOINT);
            $this->client->addSubscriber(new OauthPlugin($config));
        } else {
            throw new ApiException('Missing parameters');
        }
    }

	private function request($service='', $action='', $params=array(), $method='GET') {
        // Set the user_id
        $params['userid'] = $this->user_id;

        // action is just a querystring
        if(!empty($action)) {
            $params['action'] = $action;
        }

        // Build a request
        $request = $this->client->get($service);
            
        // Params will almost never be empty, but we'll do it like this;
        $query = $request->getQuery();
            
        foreach($params as $key => $val) {
            $query->set($key, $val);
        }

        // Decode the response
        $response = json_decode($request->send()->getBody(true), true); 

        if($response['status'] !== 0) {
            if(isset($this->errors[$response['status']])) {
                throw new WbsException($this->errors[$response['status']], $response['status']);
            }
        }

        // Check 
        if(isset($response['body']))
            return $response['body'];
    
        // We'll return true if nothing else has happened...
        return true;
    }

    public function getUser() {
        $user = $this->request('user', 'getbyuserid');

        // Why does withings return an array on this one?
        // We are querying for a user by userid... 
        $user = end($user['users']);

        return new Collection\User($user);
    }

    public function getActivity(array $params=array()) {
        if(empty($params) || !isset($params['date'])) {
            throw new ApiException('Parameter "date" can\'t be empty');
        }

        // Activity... I don't have any withingsproducts that have
        // activites so this is untested...
        $activity = $this->request('v2/measure', 'getactivity');

        return new Collection\Activity($activity);
    }

    public function getMeasures(array $params=array()) {
    	// Returns Measure
        $measure = $this->request('measure', 'getmeas', $params);

        return new Collection\Measure($measure);
    }

    public function subscribe($callback='',$comment='',$appli=1) {
        if(empty($callback)) {
            throw new ApiException('First parameter "callback" can\'t be empty');
        }

        if(empty($comment)) {
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

    public function unsubscribe($callback='', $appli=1) {
        if(empty($callback)) {
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

    public function listSubscriptions($appli=1) {
        $list = $this->request('notify', 'list', array('appli' => $appli));
        return new Collection\SubscriptionList($list);
    }

    public function isSubscribed($callback='', $appli=1) {
        if(empty($callback)) {
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