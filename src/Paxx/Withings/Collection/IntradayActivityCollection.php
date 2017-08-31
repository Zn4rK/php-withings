<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Paxx\Withings\Entity\IntradayActivity;

class IntradayActivityCollection extends Collection {

    public function __construct(array $params = array()) {
        parent::__construct();
        
        foreach ($params['series'] as $timestamp => $activity)
        {
            $this->push(new IntradayActivity($activity, $timestamp));
        }
        
        unset($params);
    }
}