<?php

namespace Paxx\Withings\Entity;

class MeasureGroupCategory
{
    /**
     * Category raw value (1 for "measure", 2 for "target")
     * 
     * @var array
     */
    public static $categoriesMap = array(
        1 => 'Measure', // Real measurements
        2 => 'Target',  // User objectives
    );
    
    public $id;
    public $name;
    
    public function __construct($categoryId)
    {
        $this->id = $categoryId;
        $this->name = self::$categoriesMap[$categoryId];
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