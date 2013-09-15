<?php
namespace Paxx\Withings\Oauth;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Guzzle\Common\Event;
use Guzzle\Plugin\Oauth\OauthPlugin as GuzzleOauth;

class OauthPlugin extends GuzzleOauth implements EventSubscriberInterface
{
    public function __construct($config)
    {
        parent::__construct($config);
    }

    public function onRequestBeforeSend(Event $event)
    {
        $timestamp = $this->getTimestamp($event);
        $request = $event['request'];
        $nonce = $this->generateNonce($request);

        $authorizationParams = array(
            'oauth_consumer_key'     => $this->config['consumer_key'],
            'oauth_nonce'            => $nonce,
            'oauth_signature'        => $this->getSignature($request, $timestamp, $nonce),
            'oauth_signature_method' => $this->config['signature_method'],
            'oauth_timestamp'        => $timestamp,
            'oauth_token'            => $this->config['token'],
            'oauth_version'          => $this->config['version'],
        );

        // Stupid Withings has not implemented the Oauth1 API according to the specs.
        // So we need to use querystrings instead...
        $query = $request->getQuery();

        // Fetch the query params;
        $params = $query->getAll();
        $params = $params+$authorizationParams;

        // Sort them
        ksort($params);

        $query = $query->clear();

        foreach($params as $key => $value) {
        	$query->set($key, $value);
        }

        return $authorizationParams;
    }
}