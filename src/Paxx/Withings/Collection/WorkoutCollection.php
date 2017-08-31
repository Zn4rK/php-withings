<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Paxx\Withings\Entity\Workout;

class WorkoutCollection extends Collection {

    public function __construct(array $params = array()) {
        parent::__construct();
        
        foreach ($params['series'] as $workout)
        {
            $this->push(new Workout($workout));
        }
        
        unset($params);
    }
}