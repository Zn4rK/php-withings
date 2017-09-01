<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Paxx\Withings\MeasureCollection\Workout;

class WorkoutCollection extends Collection {

    public static function fromParams(array $params = array())
    {
        $instance = new self();
        
        //$instance->raw = $params;
        
        foreach ($params['series'] as $workout)
        {
            $instance->push(Workout::fromParams($workout));
        }
        
        unset($params);
        
        return $instance;
    }

}