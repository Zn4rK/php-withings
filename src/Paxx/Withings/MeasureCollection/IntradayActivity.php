<?php

namespace Paxx\Withings\MeasureCollection;

use Paxx\Withings\Collection\MeasureCollection;
use Carbon\Carbon;

class IntradayActivity extends MeasureCollection
{
    /**
     * @var Carbon
     */
    public $createdAt; // activityDate

    /**
     * @link https://developer.health.nokia.com/api/doc#api-Measure-get_intraday_measure
     */
    public static $measuresMap = array(
        'calories'  => [ 'code' => 'calories',  'unit' => 'kcal' ],
        'distance'  => [ 'code' => 'distance',  'unit' => 'm' ],
        'duration'  => [ 'code' => 'duration',  'unit' => 's' ],
        'elevation' => [ 'code' => 'elevation', 'unit' => 'm' ],
        'steps'     => [ 'code' => 'steps',     'unit' => null ],
        'stroke'    => [ 'code' => 'stroke',    'unit' => null ],
        'pool_lap'  => [ 'code' => 'poolLap',   'unit' => null ],
    );
    
    /**
     * @param array $params
     */
    public static function fromParams(array $params = array(), $timestamp)
    {
        $instance = static::fromEntries(
            $params, 
            function ($entryKey, $entryValue) {
               if (array_key_exists($entryKey, self::$measuresMap))
               {
                    $measureEntry = self::$measuresMap[$entryKey];
                    return [
                        'code'  => $measureEntry['code'],
                        'value' => $entryValue,
                        'unit'  => $measureEntry['unit'],
                        'extra' => null,
                    ];
                } 
            }
        );
        
        //$instance->raw = $params;
        $instance->createdAt = Carbon::createFromTimestamp($timestamp);
        
        return $instance;
    }

}
