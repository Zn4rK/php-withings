<?php

namespace Paxx\Withings\Entity;

use Paxx\Withings\Traits\MapUtils;

class MeasureGroupCategory
{
    use MapUtils;
    
    /**
     * Category raw value (1 for "measure", 2 for "target")
     * 
     * @var array
     */
    public static $categoriesMap = array(
        1 => [ 'name' => 'Measure', 'desc' => 'Real measurements' ],
        2 => [ 'name' => 'Target',  'desc' => 'User objectives' ],
    );
    
    public $id;
    public $name;
    
    public function __construct($categoryId)
    {
        $this->id = $categoryId;
        
        $category = self::getFromMap(self::$categoriesMap, 'category', $categoryId);
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
    
}