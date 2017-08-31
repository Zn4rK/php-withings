<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection as Collection;
use Paxx\Withings\Entity\Subscription;

class SubscriptionCollection extends Collection {

    /**
     * @param array $params
     */
    public function __construct(array $params = array()) {
        foreach($params['profiles'] as &$profile) {
            $profile = new Subscription($profile);
        }

        parent::__construct($params['profiles']);
        unset($params);
    }

}