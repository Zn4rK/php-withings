<?php

namespace Paxx\Withings\Collection;

/**
 * Collection of key/value pairs
 *
 * Note: This is essentially a stdClass object; two parameters with the same key will be overwritten.
 *
 * @package Paxx\Withings\Collection
 */
abstract class Collection
{
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
