<?php

namespace Paxx\Withings\Entity;

use Carbon\Carbon;

class SleepState
{
    /**
     * @doc https://developer.health.nokia.com/api/doc#api-Measure-get_sleep
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
        $this->code = self::$stateMap[$stateId]['code'];
        $this->desc = self::$stateMap[$stateId]['desc'];
        $this->startDate = Carbon::createFromTimestamp($startDate);
        $this->endDate = Carbon::createFromTimestamp($endDate);
    }
    
}