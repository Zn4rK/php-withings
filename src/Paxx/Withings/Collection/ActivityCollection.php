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
                $instance->push(Activity::fromParams($activity));
            }
        }
        else
        {
            // We only have one item
            $instance->push(Activity::fromParams($params));
        }
        
        unset($params);
        
        return $instance;
    }

}