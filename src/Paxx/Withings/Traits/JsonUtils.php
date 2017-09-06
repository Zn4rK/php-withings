<?php

namespace Paxx\Withings\Traits;

use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

trait JsonUtils
{
    /**
     * Returns an array of parameters to serialize when this is serialized with
     * json_encode().
     *
     * @return array
     */
    private function jsonSerializeProperties($properties = [])
    {
        $json = [];
        foreach ($properties as $property)
            if (isset($this->{$property})) // Don't serialize null properties
                $json[$property] = self::valueToJson($this->{$property});
        
        return $json;
    }
    
    // Mostly from https://github.com/illuminate/support/blob/master/Collection.php#jsonSerialize()
    private static function valueToJson($value)
    {
        if ($value instanceof JsonSerializable) {
            return $value->jsonSerialize();
        } elseif ($value instanceof Jsonable) {
            return json_decode($value->toJson(), true);
        } elseif ($value instanceof Arrayable) {
            return $value->toArray();
        } elseif (is_array($value)) {
            return array_map(['self', 'valueToJson'], $value);
        } else {
            return $value;
        }
    }

}