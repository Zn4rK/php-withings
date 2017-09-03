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
    
    /**
     * Retreive an extra property
     *
     * @return mixed
     */
    public function __get($propertyName)
    {
        return (array_key_exists($propertyName, $this->extra)) ? $this->extra[$propertyName] : null;
    }
    
    /**
     * Retreive a measure information ; $measure->getCode() for example
     * Try to look in  extra properties if it doesn't exists
     *
     * @return Measure
     */
    public function __call($methodName, $arguments)
    {
        if (strncmp($methodName, 'get', 3) === 0)
        {
            $property = lcfirst(substr($methodName, 3));
            // We may check if $this->{$property} is public here .. But it needs Reflection and this seems slow
            // This is only an helper / retrocompat' feature to have getCreatedAt() for example
            return (property_exists($this, $property)) ? $this->{$property} : $this->__get($property);
        }
        else // Try to access an undefined or non-public function not starting with get
        {
            $exception = (PHP_MAJOR_VERSION < 7) ? '\Exception' : '\Error'; // Try to imitate PHP behaviour
            throw new $exception(sprintf('Call to undefined or private method %s::%s()', get_called_class(), $methodName));
        }
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

    public function __toString()
    {
        return $this->code.': '.$this->formatted();
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