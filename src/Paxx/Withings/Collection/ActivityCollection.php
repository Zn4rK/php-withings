<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Paxx\Withings\Entity\Activity;

class ActivityCollection extends Collection {

    public function __construct(array $params = array()) {
        $items = array();

        if(isset($params['activities']))
        {
            foreach($params['activities'] as &$activity)
            {
                $activity = new Activity($activity);
            }

            $items = $params['activities'];
        }
        else
        {
            // We only have one item
            $items[] = $params;
        }

        parent::__construct($items);
        unset($params);
    }
}