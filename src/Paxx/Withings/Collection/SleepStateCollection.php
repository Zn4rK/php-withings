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
    
    public function __construct(array $params = array()) {
        $this->model = new Device($param['model']);
        
        parent::__construct();
        
        foreach ($params['series'] as $timestamp => $sleepState)
        {
            $sleepState = new SleepState(
                $sleepState['state'],
                $sleepState['startdate'],
                $sleepState['enddate']
            );
            $this->put($sleepState->startDate, $sleepState);
        }
        
        unset($params);
    }
}