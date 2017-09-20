<?php

namespace Paxx\Withings\Entity;

use JsonSerializable;
use Paxx\Withings\Traits\MapUtils;

class Device implements JsonSerializable
{
    use MapUtils;
    
    /**
     * Models
     * 
     * @link https://developer.health.nokia.com/api/doc#api-Measure-get_sleep
     * @var array
     */
    public static $modelMap = array(
        0  => [
            'code' => 'userRelated',
            'name' => 'User related',
        ],
        1  => [
            'code' => 'bodyScale',
            'name' => 'Body Scale',
        ],
        4  => [
            'code' => 'bloodPressure',
            'name' => 'Blood pressure monitor',
        ],
        16 => [
            'code' => 'activityTracker',
            'name' => 'Activity Tracker',
        ],
        32 => [
            'code' => 'aura',
            'name' => 'Aura',
            'provideSleepRem' => true,
        ],
        // 51 seen on a Workout created on https://dashboard.health.nokia.com/ (with attrib 0 though ..)
    );
    
    
    public $id;
    public $name;
    
    public function __construct($modelId)
    {
        $this->id = $modelId;
        
        $model = self::getFromMap(self::$modelMap, 'device', $modelId);
        $this->code = $model['code'];
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
        return (isset(self::$this->modelMap[$modelId]['provideRem']) && self::$this->modelMap[$modelId]['provideRem']);
    }
    
    public function jsonSerialize() {
        return $this->code;
    }
}