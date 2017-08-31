<?php

namespace Paxx\Withings\Entity;

use Carbon\Carbon;
use Paxx\Withings\Collection\MeasureCollection;
use Paxx\Withings\Entity\MeasureGroupAttrib;
use Paxx\Withings\Entity\MeasureGroupCategory;

class MeasureGroup
{
    /**
     * @doc https://developer.health.nokia.com/api/doc#api-Measure-get_measure
     * @var array
     */
    public static $measuresMap = array(
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
        $this->attrib = new MeasureGroupAttrib($params['attrib']);
        $this->category = new MeasureGroupCategory($params['category']);

        $this->measures = new MeasureCollection(
            $params['measures'],
            function ($entryKey, $entryValue) {
                if (array_key_exists($entryValue['type'], self::$measuresMap)) {
                    return [
                        'code' => self::$measuresMap[$entryValue['type']]['code'],
                        'value' => $entryValue['value'] * pow(10, $entryValue['unit']),
                        'unit' => self::$measuresMap[$entryValue['type']]['unit'],
                        'extra' => [ 'id' => $entryValue['type'] ],
                    ];
                }
            }
        );
    }
    
    /**
     * List eh available measures
     *
     * @return Array
     */
    public function getMeasureList()
    {
        return $this->measures->keys();
    }
    
    /**
     * Retreive a measure by it's code
     *
     * @return Measure
     */
    public function __get($name)
    {
        return $this->measures->get($name);
    }

    /**
     * bone ratio
     *
     * @return float
     */
    public function getBoneRatio()
    {
        return new Measure('boneRatio', $this->getBoneMass()->value/$this->getWeight()->value * 100, '%');
    }

    /**
     * fat free ratio
     *
     * @return float
     */
    public function getFatFreeRatio()
    {
        return new Measure('fatFreeRatio', $this->getFatFreeMass()->value/$this->getWeight()->value * 100, '%');
    }

    /**
     * muscle ratio
     *
     * @return float
     */
    public function getMuscleRatio()
    {
        return new Measure('muscleRatio', $this->getMuscleMass()->value/$this->getWeight()->value * 100, '%');
    }

    /**
     * hydration ratio
     *
     * @return float
     */
    public function getHydrationRatio()
    {
        return new Measure('hydrationRatio', $this->getHydration()->value/$this->getWeight()->value * 100, '%');
    }
}
