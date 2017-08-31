<?php namespace Paxx\Withings\Collection;

use Illuminate\Support\Collection;
use Carbon\Carbon;
use Paxx\Withings\Entity\MeasureGroup;

class MeasureGroupCollection extends Collection {

    /**
     * @var Carbon
     */
    public $updatedAt;

    public function __construct(array $params = array()) {
        $this->raw = $params;
        $this->updatedAt = Carbon::createFromTimestamp($params['updatetime'], $params['timezone']);
        
        parent::__construct();
        foreach ($params['measuregrps'] as $group)
        {
            $this->put($group['grpid'], new MeasureGroup($group, $params['timezone']));
        }
        
        unset($params);
    }

}