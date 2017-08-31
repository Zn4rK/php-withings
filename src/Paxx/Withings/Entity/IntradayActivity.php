<?php

namespace Paxx\Withings\Entity;

use Paxx\Withings\Collection\MeasureCollection;
use Carbon\Carbon;

class IntradayActivity extends MeasureCollection
{
    /**
     * @var Carbon
     */
    public $createdAt; // activityDate

    /**
     * @doc https://developer.health.nokia.com/api/doc#api-Measure-get_intraday_measure
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
    public function __construct(array $params = array(), $timestamp)
    {
        $this->createdAt = Carbon::createFromTimestamp($timestamp);
        
        parent::__construct(
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
    }

}
