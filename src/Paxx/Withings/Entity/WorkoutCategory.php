<?php

namespace Paxx\Withings\Entity;

use Paxx\Withings\Traits\MapUtils;

class WorkoutCategory
{
    use MapUtils;
    
    /**
     * Categories
     * 
     * @link https://developer.health.nokia.com/api/doc#api-Measure-get_workouts
     * @var array
     */
    public static $categoriesMap = array(
        1 =>   [ 'code' => 'walk',          'name' => 'Walk' ],
        2 =>   [ 'code' => 'run',           'name' => 'Run' ],
        3 =>   [ 'code' => 'hiking',        'name' => 'Hiking' ],
        4 =>   [ 'code' => 'staking',       'name' => 'Staking' ],
        5 =>   [ 'code' => 'bmx',           'name' => 'BMX' ],
        6 =>   [ 'code' => 'bicycling',     'name' => 'Bicycling' ],
        7 =>   [ 'code' => 'swim',          'name' => 'Swim' ],
        8 =>   [ 'code' => 'surfing',       'name' => 'Surfing' ],
        9 =>   [ 'code' => 'kitesurfing',   'name' => 'Kitesurfing' ],
        10 =>  [ 'code' => 'windsurfing',   'name' => 'Windsurfing' ],
        11 =>  [ 'code' => 'bodyboard',     'name' => 'Bodyboard' ],
        12 =>  [ 'code' => 'tennis',        'name' => 'Tennis' ],
        13 =>  [ 'code' => 'tableTennis',   'name' => 'Table Tennis' ],
        14 =>  [ 'code' => 'squash',        'name' => 'Squash' ],
        15 =>  [ 'code' => 'badminton',     'name' => 'Badminton' ],
        16 =>  [ 'code' => 'liftWeights',   'name' => 'Lift Weights' ],
        17 =>  [ 'code' => 'calisthenics',  'name' => 'Calisthenics' ],
        18 =>  [ 'code' => 'elliptical',    'name' => 'Elliptical' ],
        19 =>  [ 'code' => 'pilate',        'name' => 'Pilate' ],
        20 =>  [ 'code' => 'basketball',    'name' => 'Basketball' ],
        21 =>  [ 'code' => 'soccer',        'name' => 'Soccer' ],
        22 =>  [ 'code' => 'football',      'name' => 'Football' ],
        23 =>  [ 'code' => 'rugby',         'name' => 'Rugby' ],
        24 =>  [ 'code' => 'volleyball',    'name' => 'Volleyball' ],
        25 =>  [ 'code' => 'waterPolo',     'name' => 'Water Polo' ],
        26 =>  [ 'code' => 'horseRiding',   'name' => 'Horse Riding' ],
        27 =>  [ 'code' => 'golf',          'name' => 'Golf' ],
        28 =>  [ 'code' => 'yoga',          'name' => 'Yoga' ],
        29 =>  [ 'code' => 'dancing',       'name' => 'Dancing' ],
        30 =>  [ 'code' => 'boxing',        'name' => 'Boxing' ],
        31 =>  [ 'code' => 'fencing',       'name' => 'Fencing' ],
        32 =>  [ 'code' => 'wrestling',     'name' => 'Wrestling' ],
        33 =>  [ 'code' => 'martialArts',   'name' => 'Martial Arts' ],
        34 =>  [ 'code' => 'skiing',        'name' => 'Skiing' ],
        35 =>  [ 'code' => 'snowboarding',  'name' => 'Snowboarding' ],
        192 => [ 'code' => 'handball',      'name' => 'Handball' ],
        186 => [ 'code' => 'base',          'name' => 'Base' ],
        187 => [ 'code' => 'rowing',        'name' => 'Rowing' ],
        188 => [ 'code' => 'zumba',         'name' => 'Zumba' ],
        191 => [ 'code' => 'baseball',      'name' => 'Baseball' ],
        192 => [ 'code' => 'handball',      'name' => 'Handball' ],
        193 => [ 'code' => 'hockey',        'name' => 'Hockey' ],
        194 => [ 'code' => 'iceHockey',     'name' => 'Ice Hockey' ],
        195 => [ 'code' => 'climbing',      'name' => 'Climbing' ],
        196 => [ 'code' => 'iceSkating',    'name' => 'Ice Skating' ],
    );
    
    public $id;
    public $code;
    public $name;
    
    public function __construct($categoryId)
    {
        $this->id = $categoryId;
        $category = self::getFromMap(self::$categoriesMap, 'category', $categoryId);
        $this->code = $category['code'];
        $this->name = $category['name'];
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