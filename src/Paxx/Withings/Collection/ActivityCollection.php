<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Paxx\Withings\Entity\Activity;

class ActivityCollection extends Collection {

    public function __construct(array $params = array()) {
        parent::__construct();
        
        if(isset($params['activities']))
        {
            foreach($params['activities'] as $activity)
            {
                $activity = new Activity($activity);
                $this->put($activity->createdAt, $activity);
            }
        }
        else
        {
            // We only have one item
            $activity = new Activity($params);
            $this->put($activity->createdAt, $activity);
        }
        
        unset($params);
    }
}