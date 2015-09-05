<?php
require_once '../vendor/autoload.php';

use Paxx\Withings\Api as WithingsApi;
use Paxx\Withings\Server\Withings as WithingsAuth;

session_start();

$config = array(
    'identifier' => 'your-key',
    'secret' => 'your-secret',
    'callback_uri' => 'http://your-callback.tld'
);

$server = new WithingsAuth($config);

if (isset($_GET['oauth_token'])) {
    // Step 2

    // Retrieve the temporary credentials from step 2
    $temporaryCredentials = unserialize($_SESSION['temporary_credentials']);

    // Retrieve token credentials - you can save these for permanent usage
    $tokenCredentials = $server->getTokenCredentials($temporaryCredentials, $_GET['oauth_token'], $_GET['oauth_verifier']);

    // Also save the userId
    $userId = $_GET['userid'];
} else {
    // Step 1

    // These identify you as a client to the server.
    $temporaryCredentials = $server->getTemporaryCredentials();

    // Store the credentials in the session.
    $_SESSION['temporary_credentials'] = serialize($temporaryCredentials);

    // Redirect the resource owner to the login screen on Withings.
    $server->authorize($temporaryCredentials);
}

$config = $config + array(
    'access_token' => $tokenCredentials->getIdentifier(),
    'token_secret' => $tokenCredentials->getSecret(),
    'user_id'      => $userId
);

$api = new WithingsApi($config);
$user = $api->getUser();

echo '<pre>' . print_r($user, true) . '</pre>';