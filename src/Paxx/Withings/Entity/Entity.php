<?php namespace Paxx\Withings\Entity;
/**
 * Collection of key/value pairs
 *
 * Note: This is essentially a stdClass object; two parameters with the same key will be overwritten.
 *
 * @package Paxx\Withings\Entity
 */
abstract class Entity
{
    protected $imperial = false;

    /**
     * @param $value
     * @param $unit
     * @return float
     */
    protected function convert($value, $unit)
    {
        $conversion = array(
            'kg'   => 2.20462,     // lbs
            'm'    => 0.393701,    // ft
            'mmHg' => 0.0193367747 // psi
        );

        if($this->imperial === false) {
            return $value;
        }

        // Reset the imperial bool
        $this->imperial = false;

        // returning and rounding to two decimals, so we're consistant with the metric
        return round($value * $conversion[$unit], 2);
    }

    /**
     * @return $this
     */
    public function imperial()
    {
        $this->imperial = true;
        return $this;
    }

}