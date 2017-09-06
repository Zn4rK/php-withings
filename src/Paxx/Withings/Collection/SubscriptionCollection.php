<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection as Collection;
use Paxx\Withings\Entity\Subscription;

class SubscriptionCollection extends Collection
{

    /**
     * @param array $params
     */
    public static function fromParams(array $params = array())
    {
        $instance = new self();
        
        //$instance->raw = $params;
        
        foreach($params['profiles'] as $profile)
        {
            $instance->push(new Subscription($profile));
        }

        unset($params);
        
        return $instance;
    }

}