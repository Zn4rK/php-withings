<?php

namespace Paxx\Withings\Client;

use \Guzzle\Http\Client as GuzzleClient;
use Paxx\Withings\Oauth\OauthPlugin;

class Client extends GuzzleClient {
	public function setOauth($provider=null,$tokens) {
		if(is_array($tokens)) $tokens = (object)$tokens;

		if (isset($provider, $tokens)) {
            $data = array(
                'consumer_key' 	   => $provider->consumer->client_id,
                'consumer_secret'  => $provider->consumer->secret,
                'signature_method' => $provider->signature->name,
                'token' 		   => $tokens->access_token,
                'token_secret'	   => $tokens->secret
            );

	        $this->addSubscriber(new OauthPlugin($data));  
        }
	}
}
