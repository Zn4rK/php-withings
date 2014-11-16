<?php

namespace Paxx\Withings\Oauth;

use Guzzle\Common\Event;
use Guzzle\Plugin\Oauth\OauthPlugin as GuzzleOauth;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OauthPlugin extends GuzzleOauth implements EventSubscriberInterface
{
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

        // Withings has not implemented the Oauth1 API according to the specs,
        // so we need to use querystrings instead.
        $query = $request->getQuery();

        // Fetch the query params
        $params = $query->getAll();
        $params = $params+$authorizationParams;

        // Sort the query params
        ksort($params);

        $query = $query->clear();

        foreach ($params as $key => $value) {
            $query->set($key, $value);
        }

        return $authorizationParams;
    }
}
