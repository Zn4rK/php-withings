<?php

namespace Paxx\Withings\Collection;

use Paxx\Withings\Exception\MeasureException;

class MeasureType extends Collection
{
    private $types = array(
        1  => 'weight',
        4  => 'height',
        5  => 'fat_free_mass',
        6  => 'fat_ratio',
        8  => 'fat_mass_weight',
        9  => 'diastolic_blood_pressure',
        10 => 'systolic_blood_pressure',
        11 => 'heart_pulse'
    );

    public function __construct(array $params = array())
    {
        foreach ($params as $measure) {
            if (isset($this->types[$measure['type']])) {
                $this->{$this->types[$measure['type']]} = ($measure['value'] * pow(10, $measure['unit']));
            }
        }
    }

    // This could've been done a bit better...
    /**
     * Get the imperial-converted value for a given type
     *
     * @param string $type      Key name of one of the $types
     * @return float
     * @throws MeasureException If $type doesn't exist
     */
    public function getImperial($type = '')
    {
        if (! $key = array_search($type, $this->types)) {
            throw new MeasureException("Type '$type' does not exists");
        }

        if (! isset($this->{$type})) {
            return false;
        }

        $value = $this->{$type};

        $conversion = array(
            'kg'   => 2.20462,     // lbs
            'm'    => 0.393701,    // ft
            'mmHg' => 0.0193367747 // psi
        );

        switch ($key) {
            case 1:
            case 5:
            case 8:
                $unit = $conversion['kg'];
                break;

            case 4:
                $unit = $conversion['m'];
                break;

            case 9:
            case 10:
                $unit = $conversion['mmHg'];
                break;
        }

        if (isset($unit)) {
            return $value * $unit;
        }

        return $value;
    }
}
