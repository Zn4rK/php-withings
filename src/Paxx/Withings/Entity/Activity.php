<?php namespace Paxx\Withings\Entity;

use Carbon\Carbon;
use Measure;

class Activity
{
    /**
     * @var Carbon
     */
    public $createdAt;

    /**
     * @var Measure
     */
    public $steps;

    /**
     * @var Measure
     */
    public $distance;

    /**
     * @var Measure
     */
    public $calories;

    /**
     * @var Measure
     */
    public $elevation;

    /**
     * @var Measure
     */
    public $soft;

    /**
     * @var Measure
     */
    public $moderate;

    /**
     * @var Measure
     */
    public $intense;

    /*public static $unitMap = array(
        [ 'code' => 'steps'
        'distance',  'm');
        'calories',  'kcal');
        'elevation', 'm');
        'soft',      's');
        'moderate',  's');
        'intense',   's'
    )*/
    public function __construct(array $params = array())
    {
        $this->createdAt = Carbon::createFromFormat('Y-m-d', $params['date'], $params['timezone']);
        //$this->measures  = new MeasureCollection($unitMap, $key, $value, $mult)
        // @doc https://developer.health.nokia.com/api/doc#api-Measure-get_activity
        $this->steps        = new Measure($params['steps']);
        $this->distance     = new Measure($params['distance'],  'm');
        $this->calories     = new Measure($params['calories'],  'kcal');
        $this->elevation    = new Measure($params['elevation'], 'm');
        $this->soft         = new Measure($params['soft'],      's');
        $this->moderate     = new Measure($params['moderate'],  's');
        $this->intense      = new Measure($params['intense'],   's');
    }

}
