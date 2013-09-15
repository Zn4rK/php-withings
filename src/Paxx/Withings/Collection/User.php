<?php

namespace Paxx\Withings\Collection;

class User extends Collection {
	public function __construct(array $params = array()) {

		// Birthdate:
		$params['timestamp'] = $params['birthdate'];
		$params['birthdate'] = gmdate('Y-m-dTH:i:sZ', $params['birthdate']);

		parent::__construct($params);
	}
}