<?php

namespace Paxx\Withings\Collection;

class Measure extends Collection
{
	public function __construct(array $params = array()) {
		foreach($params['measuregrps'] as &$group) {
			$group = new MeasureGroup($group);
		}

		// Set timestamp and make the API more consistent with the rest
		$params['timestamp']	= $params['updatetime'];
		$params['updatetime'] 	= gmdate('Y-m-dTH:i:sZ', $params['updatetime']);
		$params['groups'] 		= $params['measuregrps'];

		// Unset some stuffs we don't need
		unset($params['measuregrps']);

		parent::__construct($params);
	}
}