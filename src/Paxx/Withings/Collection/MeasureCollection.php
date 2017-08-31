<?php namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use Paxx\Withings\Entity\Measure;

class MeasureCollection extends Collection
{
    public static $attribMap = array(
        0 => [
            'code' => 'userDevice',
            'desc' => 'The measuregroup has been captured by a device and is known to belong to this user (and is not ambiguous)'
        ],
        1 => [
            'code' => 'sharedDevice',
            'desc' => 'The measuregroup has been captured by a device but may belong to other users as well as this one (it is ambiguous)'
        ],
        2 => [
            'code' => 'userManual',
            'desc' => 'The measuregroup has been entered manually for this particular user'
        ],
        4 => [
            'code' => 'userCreation',
            'desc' => 'The measuregroup has been entered manually during user creation (and may not be accurate)'
        ],
        5 => [
            'code' => 'autoBloodPressure',
            'desc' => 'Measure auto, it\'s only for the Blood Pressure Monitor. This device can make many measures and computed the best value'
        ],
        7 => [
            'code' => 'confirmedActivity',
            'desc' => 'Measure confirmed. You can get this value if the user confirmed a detected activity'
        ],
    );
    
    /**
     * Category raw value (1 for "measure", 2 for "target")
     * 
     * @var array
     */
    public static $categoriesMap = array(
        1 => 'Measure', // Real measurements
        2 => 'Target',  // User objectives
    );
    
    /**
     * @doc https://developer.health.nokia.com/api/doc#api-Measure-get_measure
     * @var array
     */
    public static $typesMap = array(
        1  => [ 'code' => 'weight',                 'unit' => 'kg'],
        4  => [ 'code' => 'height',                 'unit' => 'm'],
        5  => [ 'code' => 'fatFreeMass',            'unit' => 'kg'],
        6  => [ 'code' => 'fatRatio',               'unit' => '%'],
        8  => [ 'code' => 'fatMassWeight',          'unit' => 'kg'],
        9  => [ 'code' => 'diastolicBloodPressure', 'unit' => 'mmHg'],
        10 => [ 'code' => 'systolicBloodPressure',  'unit' => 'mmHg'],
        11 => [ 'code' => 'heartPulse',             'unit' => 'bpm'],
        12 => [ 'code' => 'temperature',            'unit' => '°C'], // Supposed as everythings seems to be intl. units
        54 => [ 'code' => 'sp02',                   'unit' => '%'],
        71 => [ 'code' => 'bodyTemperature',        'unit' => '°C'],
        73 => [ 'code' => 'skinTemperature',        'unit' => '°C'],
        76 => [ 'code' => 'muscleMass',             'unit' => 'kg'],
        77 => [ 'code' => 'hydration',              'unit' => 'kg'],
        88 => [ 'code' => 'boneMass',               'unit' => 'kg'],
        91 => [ 'code' => 'pulseWaveVelocity',      'unit' => 'm/s'], // Same supposition: m/s //  m.s^-1 ?
    );

    /**
     * @var Integer
     */
    public $groupId;
    
    /**
     * @var Carbon
     */
    public $createdAt;
    
    /**
     * @var Integer
     */
    public $attrib;

    /**
     * @var Integer
     */
    public $category;

    /**
     * @param array $params
     * @param string $timezone
     */
    public function __construct(array $params = array(), string $timezone)
    {
        $this->raw = $params;
        $this->groupId = $params['grpid'];
        $this->createdAt = Carbon::createFromTimestamp($params['date'], $timezone);
        $this->attrib = $params['attrib'];
        $this->category = $params['category'];

        $measures = [];
        foreach ($params['measures'] as $measure) {
            if (array_key_exists($measure['type'], self::$typesMap)) {
                $code = self::$typesMap[$measure['type']]['code'];
                $measures[$code] = [
                    'id' => $measure['type'],
                    'code' => $code,
                    'measure' => new Measure(
                        $measure['value'] * pow(10, $measure['unit']),
                        self::$typesMap[$measure['type']]['unit']
                    )
                ];
            }
        }
        
        parent::__construct($measures);
    }

    /**
     * Get the attrib metadatas
     *
     * @return Array
     */
    public function getAttribMetas()
    {
        return self::$attribMap[$this->attrib];
    }
    
    /**
     * Is ambiguous
     *
     * @return bool
     */
    public function isAmbiguous()
    {
        return ($this->attrib == 1 || $this->attrib == 4);
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
    public function getCategoryName()
    {
        return self::$categoriesMap[$this->category];
    }
    
    /**
     * List eh available measures
     *
     * @return Array
     */
    public function getMeasureList()
    {
        return $this->keys();
    }
    
    /**
     * Retreive a measure by it's code
     *
     * @return Measure
     */
    public function __get($name)
    {
        return $this->get($name)['measure'];
    }

    /**
     * bone ratio
     *
     * @return float
     */
    public function getBoneRatio()
    {
        return new Measure($this->getBoneMass()->value/$this->getWeight()->value * 100, '%');
    }

    /**
     * fat free ratio
     *
     * @return float
     */
    public function getFatFreeRatio()
    {
        return new Measure($this->getFatFreeMass()->value/$this->getWeight()->value * 100, '%');
    }

    /**
     * muscle ratio
     *
     * @return float
     */
    public function getMuscleRatio()
    {
        return new Measure($this->getMuscleMass()->value/$this->getWeight()->value * 100, '%');
    }

    /**
     * hydration ratio
     *
     * @return float
     */
    public function getHydrationRatio()
    {
        return new Measure($this->getHydration()->value/$this->getWeight()->value * 100, '%');
    }
}
