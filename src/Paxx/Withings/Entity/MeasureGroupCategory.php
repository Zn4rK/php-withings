<?php

namespace Paxx\Withings\Entity;

use JsonSerializable;
use Paxx\Withings\Traits\MapUtils;

class MeasureGroupCategory implements JsonSerializable
{
    use MapUtils;
    
    /**
     * Category raw value (1 for "measure", 2 for "target")
     * 
     * @var array
     */
    public static $categoriesMap = array(
        1 => [ 
            'code' => 'measure',
            'name' => 'Measure',
            'desc' => 'Real measurements'
        ],
        2 => [
            'code' => 'target',
            'name' => 'Target',
            'desc' => 'User objectives'
        ],
    );
    
    public $id;
    public $name;
    public $desc;
    
    public function __construct($categoryId)
    {
        $this->id = $categoryId;
        
        $category = self::getFromMap(self::$categoriesMap, 'category', $categoryId);
        $this->code = $category['code'];
        $this->name = $category['name'];
        $this->desc = $category['desc'];
    }
    
    /**
     * Is it a measure
     *
     * @return bool
     */
    public function isMeasure()
    {
        return ($this->category == 1);
    }

    /**
     * Is it the target measure
     *
     * @return bool
     */
    public function isTarget()
    {
        return ($this->category == 2);
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
    
    public function jsonSerialize() {
        return $this->code;
    }
    
}