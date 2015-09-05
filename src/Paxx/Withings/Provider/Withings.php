<?php namespace Paxx\Withings\Provider;

use Laravel\Socialite\One\AbstractProvider;
use Laravel\Socialite\One\User;

class Withings extends AbstractProvider
{
    /**
     * {@inheritdoc}
     */
    public function user()
    {
        if (!$this->hasNecessaryVerifier()) {
            throw new \InvalidArgumentException('Invalid request. Missing OAuth verifier.');
        }

        $user = $this->server->getUserDetails($token = $this->getToken());

        return (new User())->setRaw((array)$user)->map([
            'id'       => $user->uid,
            'nickname' => null,
            'name'     => $user->name,
            'email'    => null,
            'avatar'   => null,
        ])->setToken($token->getIdentifier(), $token->getSecret());
    }
}