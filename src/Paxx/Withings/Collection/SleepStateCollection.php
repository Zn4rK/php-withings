<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Paxx\Withings\Entity\Device;
use Paxx\Withings\Entity\SleepState;

class SleepStateCollection extends Collection {
    
    /**
     * @var SleepDevice
     */
    public $model;
    
    public static function fromParams(array $params = array())
    {
        $instance = new self();
        
        //$instance->raw = $params;
        $instance->model = new Device($params['model']);
        
        foreach ($params['series'] as $timestamp => $sleepState)
        {
            $instance->push(
                new SleepState(
                    $sleepState['state'],
                    $sleepState['startdate'],
                    $sleepState['enddate']
                )
            );
        }
        
        unset($params);
        
        return $instance;
    }

}