<?php

class core_event {

	protected $type;
	protected $in;
	protected $out;
	protected $handled;

	public function __construct($type) {
		$this->type = $type;
		$this->handled = false;
	}

	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
    	}
  	}

	public function __set($property, $value) {
    	if (property_exists($this, $property)) {
			$this->$property = $value;
    	}
    	return $this;
  	}
}
