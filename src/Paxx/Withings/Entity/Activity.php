<?php

namespace Paxx\Withings\Entity;

use Paxx\Withings\Collection\MeasureCollection;
use Carbon\Carbon;

class Activity extends MeasureCollection
{
    /**
     * @var Carbon
     */
    public $createdAt;

    /**
     * @doc https://developer.health.nokia.com/api/doc#api-Measure-get_activity
     */
    public static $measuresMap = array(
        'steps'         => [ 'code' => 'steps',         'unit' => null ],
        'distance'      => [ 'code' => 'distance',      'unit' => 'm' ],
        'calories'      => [ 'code' => 'calories',      'unit' => 'kcal' ],
        'totalcalories' => [ 'code' => 'totalCalories', 'unit' => 'kcal' ],
        'elevation'     => [ 'code' => 'elevation',     'unit' => 'm' ],
        'soft'          => [ 'code' => 'soft',          'unit' => 's' ],
        'moderate'      => [ 'code' => 'moderate',      'unit' => 's' ],
        'intense'       => [ 'code' => 'intense',       'unit' => 's' ],
    );
    
    /**
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        $this->createdAt = Carbon::createFromFormat('Y-m-d', $params['date'], $params['timezone']);
        
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
