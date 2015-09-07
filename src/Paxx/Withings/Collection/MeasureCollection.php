<?php namespace Paxx\Withings\Collection;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Paxx\Withings\Entity\Measure;

class MeasureCollection extends Collection {

    /**
     * @var Carbon
     */
    protected $updatedAt;

    public function __construct(array $params = array()) {
        $this->updatedAt = Carbon::createFromTimestamp($params['updatetime'], $params['timezone']);

        foreach ($params['measuregrps'] as &$group) {
            $group = new Measure($group);
        }

        parent::__construct($params['measuregrps']);
        unset($params);
    }

}