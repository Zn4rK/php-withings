<?php

namespace Paxx\Withings\Entity;

use Carbon\Carbon;
use Measure;

class Activity
{
    /**
     * @var Carbon
     */
    public $createdAt;

    /**
     * @doc https://developer.health.nokia.com/api/doc#api-Measure-get_activity
     */
    public static $measuresMap = array(
        'steps'     => [ 'code' => 'steps',     'unit' => null ],
        'distance'  => [ 'code' => 'distance',  'unit' => 'm' ],
        'calories'  => [ 'code' => 'calories',  'unit' => 'kcal' ],
        'elevation' => [ 'code' => 'elevation', 'unit' => 'm' ],
        'soft'      => [ 'code' => 'soft',      'unit' => 's' ],
        'moderate'  => [ 'code' => 'moderate',  'unit' => 's' ],
        'intense'   => [ 'code' => 'intense',   'unit' => 's' ],
    );
    
    /**
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        $this->createdAt = Carbon::createFromFormat('Y-m-d', $params['date'], $params['timezone']);
        $this->measures  = new MeasureCollection(
            $params, 
            function ($entryKey, $entryValue) {
               if (array_key_exists($entryKey, self::$measuresMap))
               {
                    return [
                        'code'  => self::$measuresMap[$entryKey]['code'],
                        'value' => $entryValue,
                        'unit'  => self::$measuresMap[$entryKey]['unit'],
                        'extra' => null,
                    ];
                } 
            }
        );
    }
    
    /**
     * Retreive a measure by it's code ; $activity->getSteps() for example
     *
     * @return Measure
     */
    public function __get($name)
    {
        return $this->measures->get($name);
    }

}
