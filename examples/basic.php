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

echo 'Hello ' . $user->getFirstName() . '!<br>';
echo 'Here are your measures: <hr>';

/**
 * @var \Paxx\Withings\MeasureCollection\MeasureGroup $measure
 */
foreach($user->getMeasureGroups() as $measureGroup) {
    echo $measureGroup->getCreatedAt() . ': <br>';
    if ($measureGroup->availableMeasures()->contains('weight'))
    {
        echo 'In metric: ' . $measureGroup->getWeight()->formatted() . '<br>'; // in kg
        echo 'In imperial: ' . $measureGroup->weight->asImperial()->formatted(); // in lbs
        echo '<hr>';
    }
    else
    {
        echo 'The measure group #'.$measureGroup->groupId.' doesn\'t contain weight<br>';
    }
}

/*
2017-08-30 02:30:00: 
The measure group #892135111 doesn't contain weight
2017-08-29 14:11:43: 
The measure group #890842749 doesn't contain weight
2017-08-29 14:11:43: 
In metric: 75 kg
In imperial: 165.35 lbs
*/

foreach ($user->getWorkouts() as $workout) {
    echo 'Workout of '.$workout->category->name.
        ' started at '.$workout->startDate.
        ' for '.$workout->endDate->diffForHumans($workout->startDate, true).
        ' and burned '.$workout->calories->formatted().'<hr>';
}
/*
Workout of Yoga started at 2017-08-29 02:09:00 for 1 hour and burned 209 kcal
Workout of Run started at 2017-08-30 02:09:00 for 20 minutes and burned 294 kcal
Workout of Lift Weights started at 2017-08-31 01:09:00 for 23 minutes and burned 117 kcal
Workout of Bicycling started at 2017-08-31 01:47:00 for 20 minutes and burned 313 kcal
*/