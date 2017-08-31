<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Paxx\Withings\Entity\Sleep;

class SleepCollection extends Collection {

    public function __construct(array $params = array()) {
        parent::__construct();
        
        foreach ($params['series'] as $sleep)
        {
            $sleep = new Sleep($sleep);
            $this->put($sleep->createdAt, $sleep);
        }
        
        unset($params);
    }
}