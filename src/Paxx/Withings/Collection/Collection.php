<?php

namespace Paxx\Withings\Collection;

abstract class Collection
{
	public function __construct(array $params = array()) {
		if(!empty($params)) {
			foreach($params as $name => $value) {
				$this->{$name} = $value;
			}
		}
	}
}