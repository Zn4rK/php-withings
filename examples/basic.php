<?php

include '../vendor/autoload.php';

session_start();

use Paxx\Withings\Provider\Withings as WithingsAuth;
use Paxx\Withings\Api as WithingsApi;

$config = array(
	'consumer_key' 	  => 'your-key',
	'consumer_secret' => 'your-secret',
	'redirect_url' 	  => 'http://your-callback.tld/',
);

$oauth = new WithingsAuth($config);

if ($oauth->isCallback()) {
    $oauth->validateCallback($_SESSION['token']);

    // You can save these for permanent usage
    $tokens = $oauth->getUserTokens();
} else {
    $token = $oauth->requestToken();

    // You can use any (temporary)storage you wan't.
    $_SESSION['token'] = $token;

    $url = $oauth->authorize($token);

    header("Location: {$url}");
    exit;
}

$config = $config+array(
	'access_token' 	  => $tokens->access_token,
	'token_secret' 	  => $tokens->secret,
	'user_id'		  => $tokens->uid
);

$api = new WithingsApi($config);
$user = $api->getUser();

echo '<pre>' . print_r($user, true) . '</pre>';
?>
