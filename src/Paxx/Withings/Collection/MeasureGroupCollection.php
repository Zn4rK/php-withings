<?php namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use Paxx\Withings\Collection\MeasureCollection; // use MeasureCollection pas suffisant ?!

class MeasureGroupCollection extends Collection {

    /**
     * @var Carbon
     */
    public $updatedAt;

    public function __construct(array $params = array()) {
        $this->raw = $params;
        $this->updatedAt = Carbon::createFromTimestamp($params['updatetime'], $params['timezone']);
        
        $groups = [];
        foreach ($params['measuregrps'] as $group) {
            $groups[$group['grpid']] = new MeasureCollection($group, $params['timezone']);
        }

        parent::__construct($groups);
        unset($params);
    }

}