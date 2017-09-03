<?php

namespace Paxx\Withings\Entity;

use Paxx\Withings\Traits\MapUtils;

class Device
{
    use MapUtils;
    
    /**
     * Models
     * 
     * @link https://developer.health.nokia.com/api/doc#api-Measure-get_sleep
     * @var array
     */
    public static $modelMap = array(
        16 => [ 'name' => 'Activity Tracker' ],
        32 => [ 'name' => 'Aura', 'provideSleepRem' => true ],
        // 51 seen on a Workout created on https://dashboard.health.nokia.com/ (with attrib 0 though ..)
    );
    
    
    public $id;
    public $name;
    
    public function __construct($modelId)
    {
        $this->id = $modelId;
        
        $model = self::getFromMap(self::$modelMap, 'device', $modelId);
        $this->name = $model['name'];
    }
    
    /**
     * Get the category name
     *
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }
    
    public function provideRem()
    {
        return (isset(self::$modelMap[$modelId]['provideRem']) && self::$modelMap[$modelId]['provideRem']);
    }
}