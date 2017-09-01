<?php

namespace Paxx\Withings\Entity;

class Measure
{
    public static $imperialConversionTable = array(
        'm'    => [ 'ratio' => 0.393701, 'unit' => 'ft' ],
        'kg'   => [ 'ratio' => 2.20462, 'unit' => 'lbs' ],
        'mmHg' => [ 'ratio' => 0.0193367747, 'unit' => 'psi' ],
    );
    
    public $code;
    public $value;
    public $unit;
    public $extra;
    public $isImperial = false;
    
    /**
     * @param $value
     * @param $unit
     * @return float
     */
    public function __construct(string $code, $value, string $unit, array $extra = null, $isImperial = false)
    {
        $this->code = $code;
        $this->value =$value;
        $this->unit = $unit;
        $this->extra = $extra;
        $this->isImperial = $isImperial;
    }
    
    public function __get($name)
    {
        return $this->extra[$name] ?: $this->{$name};
    }
    
    public static function fromArray(array $datas)
    {
        return new self(
            (isset($datas['code'])) ? $datas['code'] : null,
            (isset($datas['value'])) ? $datas['value'] : null,
            (isset($datas['unit'])) ? $datas['unit'] : null,
            (isset($datas['extra'])) ? $datas['extra'] : null
        );
    }
    
    public function toArray()
    {
        return [
            'code' => $this->code,
            'value' => $this->value,
            'unit' => $this->unit,
            'extra' => $this->extra,
            'is_imperial' => $this->isImperial,
        ];
    }
    
    public function formatted()
    {
        return floatval(round($this->value, 2)).' '.((!empty($this->unit)) ? $this->unit : '');
    }

    /**
     * @return Measure
     */
    public function asImperial()
    {
        if (array_key_exists($this->unit, self::$imperialConversionTable))
        {
            $converted = clone $this;
            $converted->value = round($this->value * self::$imperialConversionTable[$this->unit]['ratio'], 2);
            $converted->unit = self::$imperialConversionTable[$this->unit]['unit'];
            $converted->isImperial = true;
            return $converted;
        }
        else
        {
            return $this;
        }
    }

}