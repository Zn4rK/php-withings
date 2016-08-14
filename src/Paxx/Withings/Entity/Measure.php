<?php

namespace Paxx\Withings\Entity;

use Carbon\Carbon;

class Measure extends Entity
{
    /**
     * @var array
     */
    private $types = array(
        1  => 'weight',
        4  => 'height',
        5  => 'fatFreeMass',
        6  => 'fatRatio',
        8  => 'fatMassWeight',
        9  => 'diastolicBloodPressure',
        10 => 'systolicBloodPressure',
        11 => 'heartPulse',
        54 => 'sp02',
        76 => 'muscleMass',
        77 => 'hydration',
        88 => 'boneMass'
    );

    /**
     * @var array
     */
    private $categories = array(
        1 => 'Measure',
        2 => 'Target',
    );

    /**
     * @var Integer
     */
    protected $attrib;

    /**
     * @var Carbon
     */
    protected $createdAt;

    /**
     * @var Integer
     */
    protected $category;

    /**
     * @var Integer
     */
    protected $groupId;

    /**
     * @var float
     */
    protected $weight;

    /**
     * @var float
     */
    protected $height;

    /**
     * @var float
     */
    protected $fatFreeMass;

    /**
     * @var float
     */
    protected $fatRatio;

    /**
     * @var float
     */
    protected $hydration;

    /**
     * @var float
     */
    protected $muscleMass;

    /**
     * @var float
     */
    protected $boneMass;

    /**
     * @var float
     */
    protected $fatMassWeight;

    /**
     * @var float
     */
    protected $diastolicBloodPressure;

    /**
     * @var float
     */
    protected $systolicBloodPressure;

    /**
     * @var float
     */
    protected $heartPulse;

    /**
     * @var float
     */
    protected $sp02;

    /**
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        $this->attrib = $params['attrib'];
        $this->createdAt = Carbon::createFromTimestamp($params['date']);
        $this->groupId = $params['grpid'];
        $this->category = $params['category'];

        foreach ($params['measures'] as $measure) {
            if (isset($this->types[$measure['type']])) {
                $this->{$this->types[$measure['type']]} = ($measure['value'] * pow(10, $measure['unit']));
            }
        }
    }

    /**
     * Get the created at date
     *
     * @return Carbon
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Weight (kg)
     *
     * Imperial conversion via $this->imperial()->getWeight()
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->convert($this->weight, 'kg');
    }

    /**
     * Height (meter)
     *
     * Imperial conversion via $this->imperial()->getHeight()
     *
     * @return float
     */
    public function getHeight()
    {
        return $this->convert($this->height, 'm');
    }

    /**
     * Free Mass (kg)
     *
     * Imperial conversion via $this->imperial()->getFatFreeMass()
     *
     * @return float
     */
    public function getFatFreeMass() {
        return $this->convert($this->fatFreeMass, 'kg');
    }

    /**
     * Fat Ratio (%)
     *
     * @return float
     */
    public function getFatRatio()
    {
        return $this->fatRatio;
    }

    /**
     * Fat Mass Weight (kg)
     *
     * Imperial conversion via $this->imperial()->getFatMassWeight()
     *
     * @return float
     */
    public function getFatMassWeight()
    {
        return $this->convert($this->fatMassWeight, 'kg');
    }

    /**
     * Diastolic Blood Pressure (mmHg)
     *
     * Imperial conversion via $this->imperial()->getDiastolicBloodPressure()
     *
     * @return float
     */
    public function getDiastolicBloodPressure()
    {
        return $this->convert($this->diastolicBloodPressure, 'mmHg');
    }

    /**
     * Systolic Blood Pressure (mmHg)
     *
     * Imperial conversion via $this->imperial()->getSystolicBloodPressure()
     *
     * @return float
     */
    public function getSystolicBloodPressure()
    {
        return $this->convert($this->systolicBloodPressure, 'mmHg');
    }

    /**
     * Heart Pulse
     *
     * @return float
     */
    public function getHeartPulse()
    {
        return $this->heartPulse;
    }

    /**
     * Sp02
     *
     * @return float
     */
    public function getSp02()
    {
        return $this->sp02;
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
        return $this->categories[$this->category];
    }

    /**
     * Get the category raw value (1 for "measure", 2 for "target")
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * bone ratio
     *
     * @return float
     */
    public function getBoneRatio()
    {
        return $this->convert($this->boneMass, 'kg')/$this->convert($this->weight, 'kg')*100;
    }

    /**
     * fat free ratio
     *
     * @return float
     */
    public function getFatFreeRatio()
    {
        return $this->convert($this->fatFreeMass, 'kg')/$this->convert($this->weight, 'kg')*100;
    }

    /**
     * muscle ratio
     *
     * @return float
     */
    public function getMuscleRatio()
    {
        return $this->convert($this->muscleMass, 'kg')/$this->convert($this->weight, 'kg')*100;
    }

    /**
     * hydration ratio
     *
     * @return float
     */
    public function getHydrationRatio()
    {
        return $this->convert($this->hydration, 'kg')/$this->convert($this->weight, 'kg')*100;
    }
}
