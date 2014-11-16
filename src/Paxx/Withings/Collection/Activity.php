<?php

namespace Paxx\Withings\Collection;

class Activity extends Collection
{
    public function __construct(array $params = array())
    {
        // Because of the capability of sending date range we need to check if there's a date.
        if (isset($params['date'])) {
            $params['timestamp'] = strtotime($params['date']);
            $params['date'] = gmdate('Y-m-dTH:i:sZ', $params['timestamp']);
        }

        parent::__construct($params);
    }
}
