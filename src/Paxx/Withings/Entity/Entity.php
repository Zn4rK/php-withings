<?php

namespace Paxx\Withings\Entity;

/**
 * Collection of key/value pairs
 *
 * Note: This is essentially a stdClass object; two parameters with the same key will be overwritten.
 *
 * @package Paxx\Withings\Entity
 */
abstract class Entity {

    /**
     * @param array $params Parameters
     */
    public function __construct(array $params = array())
    {
        if (! empty($params)) {
            foreach ($params as $name => $value) {
                $this->{$name} = $value;
            }
        }
    }


}
