<?php

namespace Paxx\Withings\Collection;

class Activity extends Collection
{
	public function __construct(array $params = array()) {
		$params['timestamp'] = strtotime($params['date']);
		$params['date'] = gmdate('Y-m-dTH:i:sZ', $params['timestamp']);

		parent::__construct($params);
	}
}