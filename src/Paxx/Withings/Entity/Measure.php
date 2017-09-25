<?php

namespace Paxx\Withings\Entity;

use JsonSerializable;
use Paxx\Withings\Traits\JsonUtils;

class Measure implements JsonSerializable
{
    use JsonUtils;
    
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
            $public_properties = array_keys(call_user_func('get_object_vars', $this));
            return (in_array($property, $public_properties)) ? $this->{$property} : $this->__get($property);
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
            (isset($datas['extra'])) ? $datas['extra'] : null,
            (isset($datas['is_imperial'])) ? $datas['is_imperial'] : (isset($datas['isImperial'])) ? $datas['isImperial'] : null
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
        if ($this->isImperial)
        {
            return $this;
        }
        elseif (array_key_exists($this->unit, self::$imperialConversionTable))
        {
            $converted = clone $this;
            $converted->value = round($this->value * self::$imperialConversionTable[$this->unit]['ratio'], 2);
            $converted->unit = self::$imperialConversionTable[$this->unit]['unit'];
            $converted->isImperial = true;
            return $converted;
        }
        else
        {
            return $this; // Or null ? Or false ? Or exception ?
        }
    }
    
    /**
     * Returns an array of parameters to serialize when this is serialized with
     * json_encode().
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $json = [];
        
        if (isset($this->code))
        {
            $json['code'] = self::valueToJson($this->code);
        }
        
        if (isset($this->value))
        {
            $json['value'] = self::valueToJson($this->value);
        }
        
        if (isset($this->unit))
        {
            $json['unit'] = self::valueToJson($this->unit);
        }
        
        // https://stackoverflow.com/questions/5543490/json-naming-convention ...
        if ($this->isImperial)
        {
            $json['isImperial'] = $this->isImperial;
        }
        
        if (!empty($this->extra))
        {
            foreach ($this->extra as $key => $extra)
            {
                if (isset($extra))
                {
                    $json['extra'][$key] = self::valueToJson($extra);
                }
            }
        }
        
        return $json;
    }

}