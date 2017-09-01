<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use Paxx\Withings\MeasureCollection\MeasureGroup;

class MeasureGroupCollection extends Collection {

    /**
     * @var Carbon
     */
    public $updatedAt;

    public static function fromParams(array $params = array())
    {
        $instance = new self();
        
        //$instance->raw = $params;
        $instance->updatedAt = Carbon::createFromTimestamp($params['updatetime'], $params['timezone']);
        
        foreach ($params['measuregrps'] as $group)
        {
            $instance->push(MeasureGroup::fromParams($group, $params['timezone']));
        }
        
        unset($params);
        
        return $instance;
    }

}