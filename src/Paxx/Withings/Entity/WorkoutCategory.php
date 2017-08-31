<?php

namespace Paxx\Withings\Entity;

class WorkoutCategory
{
    /**
     * Categories
     * 
     * @doc https://developer.health.nokia.com/api/doc#api-Measure-get_workouts
     * @var array
     */
    public static $categoriesMap = array(
        1 =>   [ 'code' => 'Walk',          'name' => 'Walk' ],
        2 =>   [ 'code' => 'Run',           'name' => 'Run' ],
        3 =>   [ 'code' => 'Hiking',        'name' => 'Hiking' ],
        4 =>   [ 'code' => 'Staking',       'name' => 'Staking' ],
        5 =>   [ 'code' => 'BMX',           'name' => 'BMX' ],
        6 =>   [ 'code' => 'Bicycling',     'name' => 'Bicycling' ],
        7 =>   [ 'code' => 'Swim',          'name' => 'Swim' ],
        8 =>   [ 'code' => 'Surfing',       'name' => 'Surfing' ],
        9 =>   [ 'code' => 'KiteSurfing',   'name' => 'KiteSurfing' ],
        10 =>  [ 'code' => 'Windsurfing',   'name' => 'Windsurfing' ],
        11 =>  [ 'code' => 'Bodyboard',     'name' => 'Bodyboard' ],
        12 =>  [ 'code' => 'Tennis',        'name' => 'Tennis' ],
        13 =>  [ 'code' => 'TableTennis',   'name' => 'Table Tennis' ],
        14 =>  [ 'code' => 'Squash',        'name' => 'Squash' ],
        15 =>  [ 'code' => 'Badminton',     'name' => 'Badminton' ],
        16 =>  [ 'code' => 'LiftWeights',   'name' => 'Lift Weights' ],
        17 =>  [ 'code' => 'Calisthenics',  'name' => 'Calisthenics' ],
        18 =>  [ 'code' => 'Elliptical',    'name' => 'Elliptical' ],
        19 =>  [ 'code' => 'Pilate',        'name' => 'Pilate' ],
        20 =>  [ 'code' => 'Basketball',    'name' => 'Basketball' ],
        21 =>  [ 'code' => 'Soccer',        'name' => 'Soccer' ],
        22 =>  [ 'code' => 'Football',      'name' => 'Football' ],
        23 =>  [ 'code' => 'Rugby',         'name' => 'Rugby' ],
        24 =>  [ 'code' => 'VollyBall',     'name' => 'VollyBall' ],
        25 =>  [ 'code' => 'WaterPolo',     'name' => 'WaterPolo' ],
        26 =>  [ 'code' => 'HorseRiding',   'name' => 'HorseRiding' ],
        27 =>  [ 'code' => 'Golf',          'name' => 'Golf' ],
        28 =>  [ 'code' => 'Yoga',          'name' => 'Yoga' ],
        29 =>  [ 'code' => 'Dancing',       'name' => 'Dancing' ],
        30 =>  [ 'code' => 'Boxing',        'name' => 'Boxing' ],
        31 =>  [ 'code' => 'Fencing',       'name' => 'Fencing' ],
        32 =>  [ 'code' => 'Wrestling',     'name' => 'Wrestling' ],
        33 =>  [ 'code' => 'MartialArts',   'name' => 'Martial Arts' ],
        34 =>  [ 'code' => 'Skiing',        'name' => 'Skiing' ],
        35 =>  [ 'code' => 'SnowBoarding',  'name' => 'SnowBoarding' ],
        192 => [ 'code' => 'Handball',      'name' => 'Handball' ],
        186 => [ 'code' => 'Base',          'name' => 'Base' ],
        187 => [ 'code' => 'Rowing',        'name' => 'Rowing' ],
        188 => [ 'code' => 'Zumba',         'name' => 'Zumba' ],
        191 => [ 'code' => 'Baseball',      'name' => 'Baseball' ],
        192 => [ 'code' => 'Handball',      'name' => 'Handball' ],
        193 => [ 'code' => 'Hockey',        'name' => 'Hockey' ],
        194 => [ 'code' => 'IceHockey',     'name' => 'IceHockey' ],
        195 => [ 'code' => 'Climbing',      'name' => 'Climbing' ],
        196 => [ 'code' => 'IceSkating',    'name' => 'IceSkating' ],
    );
    
    public static function mapNotFound($key)
    {
        return [
            'code' => '_unk'.key,
            'name' => 'Unknow category (id '.$key.')'
        ];
    }
    
    public $id;
    public $code;
    public $name;
    
    public function __construct($categoryId)
    {
        $this->id = $categoryId;
        try {
            $category = self::$categoriesMap[$categoryId];
        } catch (\Exception $e) {
            $category = self::mapNotFound($categoryId);
        }
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