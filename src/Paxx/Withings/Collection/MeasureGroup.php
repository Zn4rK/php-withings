<?php

namespace Paxx\Withings\Collection;

class MeasureGroup extends Collection
{
	private $categories = array(
		1 => 'Measure',
		2 => 'Target',
	);

	public function __construct(array $params = array()) {
		$this->measure = new MeasureType($params['measures']);
		
		// Unset unwanted stuff
		unset($params['measures']);

		// Let's call the timestamp 'timestamp' instead of 'date'
		$params['timestamp'] = $params['date'];

		// And date is now ISO 8601-complient for readability
		$params['date'] = gmdate('Y-m-dTH:i:sZ', $params['date']);

		parent::__construct($params);
	}

	public function isAmbiguous() {
		return ($this->attrib == 1 || $this->attrib == 4);
	}

	public function isMeasure() {
		return ($this->category == 1);
	}

	public function isTarget() {
		return ($this->category == 2);
	}

	public function getCategoryName() {
		return $this->categories[$this->category];
	}
}