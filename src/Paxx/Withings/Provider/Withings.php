<?php

namespace Paxx\Withings\Provider;

use OAuth1\Provider;
use OAuth1\Provider\ProviderInterface;

class Withings extends Provider implements ProviderInterface
{
    public $name     = 'withings';
    public $endpoint = 'https://oauth.withings.com/account/';
    public $uid_key  = 'userid';

    public function __construct(array $params = null)
    {
        // Normalize params
        if (isset($params['consumer_key'], $params['consumer_secret'])) {
            $params['id'] = $params['consumer_key'];
            $params['secret'] = $params['consumer_secret'];

            unset($params['consumer_key'], $params['consumer_secret']);
        }

        parent::__construct($params);
    }

    public function requestTokenUrl()
    {
        return $this->endpoint . 'request_token';
    }

    public function authorizeUrl()
    {
        return $this->endpoint . 'authorize';
    }

    public function accessTokenUrl()
    {
        return $this->endpoint . 'access_token';
    }

    public function getUserInfo()
    {
    }
}
