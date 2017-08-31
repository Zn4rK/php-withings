<?php namespace Paxx\Withings\Entity;

class Measure
{
    public static $imperialConversionTable = array(
        'm'    => [ 'ratio' => 0.393701, 'unit' => 'ft' ],
        'kg'   => [ 'ratio' => 2.20462, 'unit' => 'lbs' ],
        'mmHg' => [ 'ratio' => 0.0193367747, 'unit' => 'psi' ],
    );
    
    public $value;
    public $unit;
    public $isImperial = false;
    
    /**
     * @param $value
     * @param $unit
     * @return float
     */
    public function __construct($value, $unit=null, $isImperial=false)
    {
        $this->value = $value;
        $this->unit = $unit;
        $this->isImperial = $isImperial;
    }

    /**
     * @return Measure
     */
    public function asImperial()
    {
        if (array_key_exists($this->unit, self::$imperialConversionTable))
        {
            return new self(
                round($value * self::$imperialConversionTable[$unit]['ratio'], 2),
                self::$imperialConversionTable[$unit]['unit'],
                true
            );
        }
        else
        {
            return $this;
        }
    }

}