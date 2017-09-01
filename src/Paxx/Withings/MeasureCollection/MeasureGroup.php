<?php

namespace Paxx\Withings\MeasureCollection;

use Paxx\Withings\Collection\MeasureCollection;
use Carbon\Carbon;
use Paxx\Withings\Entity\MeasureAttrib;
use Paxx\Withings\Entity\MeasureGroupCategory;

class MeasureGroup extends MeasureCollection
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
     * @var MeasureGroupAttrib
     */
    public $attrib;

    /**
     * @var MeasureGroupCategory
     */
    public $category;

    /**
     * @param array $params
     * @param string $timezone
     */
    public static function fromParams(array $params = array(), string $timezone)
    {
        $instance = parent::fromEntries(
            $params['measures'],
            function ($entryKey, $entryValue) {
                if (array_key_exists($entryValue['type'], self::$measuresMap))
                {
                    $measureEntry = self::$measuresMap[$entryValue['type']];
                    return [
                        'code'  => $measureEntry['code'],
                        'value' => $entryValue['value'] * pow(10, $entryValue['unit']),
                        'unit'  => $measureEntry['unit'],
                        'extra' => [ 'id' => $entryValue['type'] ],
                    ];
                }
            }
        );
        
        $instance->groupId = $params['grpid'];
        $instance->createdAt = Carbon::createFromTimestamp($params['date'], $timezone);
        $instance->attrib = new MeasureAttrib($params['attrib']);
        $instance->category = new MeasureGroupCategory($params['category']);
        
        return $instance;
    }

    /**
     * bone ratio
     *
     * @return Measure
     */
    public function getBoneRatio()
    {
        return new Measure('boneRatio', $this->getBoneMass()->value/$this->getWeight()->value * 100, '%');
    }

    /**
     * fat free ratio
     *
     * @return Measure
     */
    public function getFatFreeRatio()
    {
        return new Measure('fatFreeRatio', $this->getFatFreeMass()->value/$this->getWeight()->value * 100, '%');
    }

    /**
     * muscle ratio
     *
     * @return Measure
     */
    public function getMuscleRatio()
    {
        return new Measure('muscleRatio', $this->getMuscleMass()->value/$this->getWeight()->value * 100, '%');
    }

    /**
     * hydration ratio
     *
     * @return Measure
     */
    public function getHydrationRatio()
    {
        return new Measure('hydrationRatio', $this->getHydration()->value/$this->getWeight()->value * 100, '%');
    }
}
