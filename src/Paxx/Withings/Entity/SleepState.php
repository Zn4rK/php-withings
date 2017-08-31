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
    
    public static function mapNotFound($key)
    {
        return [
            'code' => '_unk'.key,
            'desc' => 'Unknow sleep state (id '.$key.')'
        ];
    }
    
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
        
        try {
            $state = self::$stateMap[$stateId];
        } catch (\Exception $e) {
            $state = self::mapNotFound($stateId);
        }
        $this->code = $state['code'];
        $this->desc = $state['desc'];
        
    }
    
}