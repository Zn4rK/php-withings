<?php

namespace Paxx\Withings\Entity;

use Paxx\Withings\Collection\MeasureCollection;
use Carbon\Carbon;
use Paxx\Withings\Entity\Device;

class Sleep extends MeasureCollection
{
    /**
     * @var Carbon
     */
    public $createdAt; // activityDate
    
    public $startDate;
    public $endDate;
    public $model;

    /**
     * @doc https://developer.health.nokia.com/api/doc#api-Measure-get_sleep_summary
     */
    public static $measuresMap = array(
        'wakeupduration'     => [ 'code' => 'wakeupDuration',     'unit' => 's' ],
        'lightsleepduration' => [ 'code' => 'lightSleepDuration', 'unit' => 's' ],
        'deepsleepduration'  => [ 'code' => 'deepSleepDuration',  'unit' => 's' ],
        'remsleepduration'   => [ 'code' => 'remSleepDuration',   'unit' => 's', 'extra' => ['isRem' => true ] ],
        'wakeupcount'        => [ 'code' => 'wakeupCount',        'unit' => 's' ],
        'durationtosleep'    => [ 'code' => 'durationToSleep',    'unit' => 's' ],
        'durationtowakeup'   => [ 'code' => 'durationToWakeup',   'unit' => 's' ],
    );
    
    /**
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        $this->createdAt = Carbon::createFromFormat('Y-m-d', $params['date'], $params['timezone']);
        $this->startDate = Carbon::createFromTimestamp($params['startdate'], $params['timezone']);
        $this->endDate   = Carbon::createFromTimestamp($params['enddate'], $params['timezone']);
        $this->model     = new Device($params['model']);
        
        parent::__construct(
            $params['data'], 
            function ($entryKey, $entryValue) {
               if (array_key_exists($entryKey, self::$measuresMap))
               {
                   $measureEntry = self::$measuresMap[$entryKey];
                    return [
                        'code'  => $measureEntry['code'],
                        'value' => $entryValue,
                        'unit'  => $measureEntry['unit'],
                        'extra' => (isset($measureEntry['extra'])) ? $measureEntry['extra'] : null,
                    ];
                } 
            }
        );
    }

}
