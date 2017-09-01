<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Paxx\Withings\MeasureCollection\IntradayActivity;

class IntradayActivityCollection extends Collection {

    public static function fromParams(array $params = array())
    {
        $instance = new self();
        
        foreach ($params['series'] as $timestamp => $activity)
        {
            $instance->push(IntradayActivity::fromParams($activity, $timestamp));
        }
        
        unset($params);
        
        return $instance;
    }

}