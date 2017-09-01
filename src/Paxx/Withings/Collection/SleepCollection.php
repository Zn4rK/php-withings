<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Paxx\Withings\MeasureCollection\Sleep;

class SleepCollection extends Collection {

   public static function fromParams(array $params = array())
    {
        $instance = new self();
        
        //$instance->raw = $params;
        
        foreach ($params['series'] as $sleep)
        {
            $instance->push(Sleep::fromParams($sleep));
        }
        
        unset($params);
        
        return $instance;
    }

}