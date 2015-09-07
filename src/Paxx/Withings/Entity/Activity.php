<?php namespace Paxx\Withings\Entity;

use Carbon\Carbon;

class Activity extends Entity
{
    /**
     * @var Carbon
     */
    protected $createdAt;

    /**
     * @var Integer
     */
    protected $steps;

    /**
     * @var float
     */
    protected $distance;

    /**
     * @var float
     */
    protected $calories;

    /**
     * @var float
     */
    protected $elevation;

    /**
     * @var integer
     */
    protected $soft;

    /**
     * @var integer
     */
    protected $moderate;

    /**
     * @var integer
     */
    protected $intense;

    public function __construct(array $params = array())
    {
        $this->createdAt = Carbon::createFromFormat('Y-m-d', $params['date'], $params['timezone']);
        $this->steps = $params['steps'];
        $this->distance = $params['distance'];
        $this->calories = $params['calories'];
        $this->elevation = $params['elevation'];
        $this->soft = $params['soft'];
        $this->moderate = $params['moderate'];
        $this->intense = $params['intense'];
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Number of steps for the day.
     *
     * @return int
     */
    public function getSteps() {
        return $this->steps;
    }

    /**
     * Distance travelled for the day (in meters)
     *
     * Imperial conversion via $this->imperial()->getDistance()
     *
     * @return float
     */
    public function getDistance() {
        return $this->convert($this->distance, 'm');
    }

    /**
     * Active Calories burned in the day (in kcal).
     *
     * @return float
     */
    public function getCalories() {
        return $this->calories;
    }

    /**
     * Elevation climbed during the day (in meters)
     *
     * Imperial conversion via $this->imperial()->getElevation()
     *
     * @return float
     */
    public function getElevation() {
        return $this->convert($this->elevation, 'm');
    }

    /**
     * Duration of soft activities (in seconds).
     *
     * @return int
     */
    public function getSoft() {
        return $this->soft;
    }

    /**
     * Duration of moderate activities (in seconds).
     *
     * @return int
     */
    public function getModerate() {
        return $this->moderate;
    }

    /**
     * Duration of intense activities (in seconds).
     *
     * @return int
     */
    public function getIntense() {
        return $this->intense;
    }

}
