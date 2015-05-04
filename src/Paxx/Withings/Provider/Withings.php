<?php
namespace Paxx\Withings\Provider;

use League\OAuth1\Client\Credentials\TokenCredentials;
use League\OAuth1\Client\Server\Server;
use League\OAuth1\Client\Server\User;

class Withings extends Server
{
    public $endpoint = 'https://oauth.withings.com';

    /**
     * Get the URL for retrieving temporary credentials.
     *
     * @return string
     */
    public function urlTemporaryCredentials()
    {
        return $this->$endpoint . '/account/request_token';
    }

    /**
     * Get the URL for redirecting the resource owner to authorize the client.
     *
     * @return string
     */
    public function urlAuthorization()
    {
        return $this->$endpoint . '/account/authorize';
    }

    /**
     * Get the URL retrieving token credentials.
     *
     * @return string
     */
    public function urlTokenCredentials()
    {
        return $this->$endpoint . '/account/access_token';
    }

    /**
     * Get the URL for retrieving user details.
     *
     * @return string
     */
    public function urlUserDetails()
    {
        return $this->$endpoint . '/user';
    }

    /**
     * Take the decoded data from the user details URL and convert
     * it to a User object.
     *
     * @param mixed            $data
     * @param TokenCredentials $tokenCredentials
     *
     * @return User
     */
    public function userDetails($data, TokenCredentials $tokenCredentials)
    {
        // TODO: Implement userDetails() method.
    }

    /**
     * Take the decoded data from the user details URL and extract
     * the user's UID.
     *
     * @param mixed            $data
     * @param TokenCredentials $tokenCredentials
     *
     * @return string|int
     */
    public function userUid($data, TokenCredentials $tokenCredentials)
    {
        // TODO: Implement userUid() method.
    }

    /**
     * Take the decoded data from the user details URL and extract
     * the user's email.
     *
     * @param mixed            $data
     * @param TokenCredentials $tokenCredentials
     *
     * @return string
     */
    public function userEmail($data, TokenCredentials $tokenCredentials)
    {
        // TODO: Implement userEmail() method.
    }

    /**
     * Take the decoded data from the user details URL and extract
     * the user's screen name.
     *
     * @param mixed            $data
     * @param TokenCredentials $tokenCredentials
     *
     * @return string
     */
    public function userScreenName($data, TokenCredentials $tokenCredentials)
    {
        // TODO: Implement userScreenName() method.
    }

}
