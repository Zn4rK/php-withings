<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Paxx\Withings\MeasureCollection\Activity;

class ActivityCollection extends Collection
{

    public static function fromParams(array $params = array())
    {
        $instance = new self();
        
        //$instance->raw = $params;
        
        if (isset($params['activities']))
        {
            foreach ($params['activities'] as $activity)
            {
                $activity = Activity::fromParams($activity);
                $instance->push($activity);
            }
        }
        else
        {
            // We only have one item
            $activity = Activity::fromParams($params);
            $instance->push($activity);
        }
        
        unset($params);
        
        return $instance;
    }

}