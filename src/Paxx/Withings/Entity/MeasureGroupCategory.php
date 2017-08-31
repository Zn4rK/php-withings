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
    
    public static function mapNotFound($key)
    {
        return 'Unknow category (id '.$key.')';
    }
    
    public $id;
    public $name;
    
    public function __construct($categoryId)
    {
        $this->id = $categoryId;
        try {
            $category = self::$categoriesMap[$categoryId];
        } catch (\Exception $e) {
            $category = self::mapNotFound($categoryId);
        }
        $this->name = $category;
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