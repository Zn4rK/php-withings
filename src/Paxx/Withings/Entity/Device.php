<?php

namespace Paxx\Withings\Entity;

class Device
{
    /**
     * Models
     * 
     * @doc https://developer.health.nokia.com/api/doc#api-Measure-get_sleep
     * @var array
     */
    public static $modelMap = array(
        16 => [ 'name' => 'Activity Tracker' ],
        32 => [ 'name' => 'Aura', 'provideRem' => true ],
        // 51 seen on a Workout created on https://dashboard.health.nokia.com/ (with attrib 0 though ..)
    );
    
    public static function mapNotFound($key)
    {
        return [ 'name' => 'Unknow device (id '.$key.')' ];
    }
    
    public $id;
    public $name;
    
    public function __construct($modelId)
    {
        $this->id = $modelId;
        try {
            $model = self::$modelMap[$modelId];
        } catch (\Exception $e) {
            $model = self::mapNotFound($modelId);
        }
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