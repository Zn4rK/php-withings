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
    );
    
    public $id;
    public $name;
    
    public function __construct($modelId)
    {
        $this->id = $modelId;
        $this->name = self::$modelMap[$modelId]['name'];
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