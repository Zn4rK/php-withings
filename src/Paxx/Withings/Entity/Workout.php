<?php

namespace Paxx\Withings\Entity;

use Paxx\Withings\Collection\MeasureCollection;
use Carbon\Carbon;
use Paxx\Withings\Entity\Device;
use Paxx\Withings\Entity\WorkoutCategory;

class Workout extends MeasureCollection
{
    /**
     * @var Carbon
     */
    public $createdAt; // activityDate
    
    public $startDate;
    public $endDate;
    public $model;
    public $category;
    public $attrib; // HUM ??

    /**
     * @doc https://developer.health.nokia.com/api/doc#api-Measure-get_workouts
     */
    public static $measuresMap = array(
        'calories'      => [
            'code' => 'calories',
            'desc' => 'Calories burn',
            'unit' => 'kcal' 
        ],
        'strokes'       => [
            'code' => 'strokes',
            'desc' => 'Movements',
            'unit' => null
        ],
        'pool_length'   => [ 
            'code' => 'poolLength',
            'desc' => 'Size of the pool where the user swim',
            'unit' => 'm'
        ],
        'pool_laps'     => [
            'code' => 'poolLaps',
            'desc' => 'Number of laps swam by the user',
            'unit' => null
        ],
        'effduration'   => [
            'code' => 'effDuration',
            'desc' => 'Effective duration',
            'unit' => 's'
        ],
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
        $this->category  = new WorkoutCategory($params['category']);
        $this->attrib    = new MeasureAttrib($param['attrib']);
        
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
