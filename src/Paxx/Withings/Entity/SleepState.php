<?php

namespace Paxx\Withings\Entity;

use Carbon\Carbon;
use Paxx\Withings\Traits\MapUtils;

class SleepState
{
    use MapUtils;
    
    /**
     * @link https://developer.health.nokia.com/api/doc#api-Measure-get_sleep
     */
    public static $stateMap = array(
        0 => [
            'code' => 'awake',
            'desc' => 'awake'
        ],
        1 => [
            'code' => 'light',
            'desc' => 'light sleep'
        ],
        2 => [
            'code' => 'deep',
            'desc' => 'deep sleep'
        ],
        3 => [
            'code' => 'rem',
            'desc' => 'Rapid eye movement sleep (only if model is 32)'
        ],
    );
    
    public $id;
    public $code;
    public $desc;
    public $startDate;
    public $endDate;
    
    public function __construct($stateId, $startDate = null, $endDate = null)
    {
        $this->id = $stateId;
        $this->startDate = Carbon::createFromTimestamp($startDate);
        $this->endDate = Carbon::createFromTimestamp($endDate);
        
        $state = self::getFromMap(self::$stateMap, 'sleep state', $stateId);
        $this->code = $state['code'];
        $this->desc = $state['desc'];
        
    }
    
}