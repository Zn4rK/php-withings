<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Paxx\Withings\Entity\Sleep;

class SleepCollection extends Collection {

    public function __construct(array $params = array()) {
        parent::__construct();
        
        foreach ($params['series'] as $sleep)
        {
            $this->push(new Sleep($sleep));
        }
        
        unset($params);
    }
}