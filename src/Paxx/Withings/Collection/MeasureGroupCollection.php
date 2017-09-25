<?php

namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Paxx\Withings\Traits\JsonUtils;
use Carbon\Carbon;
use Paxx\Withings\MeasureCollection\MeasureGroup;

class MeasureGroupCollection extends Collection
{
    use JsonUtils;
    
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
    
    /**
     * Returns an array of parameters to serialize when this is serialized with
     * json_encode().
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $json = [];
        if (isset($this->updatedAt))
            $json['updatedAt'] = self::valueToJson($this->updatedAt);
        $json['items'] = parent::jsonSerialize();
        return $json;
    }

}