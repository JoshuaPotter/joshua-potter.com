<?php

class http_request {

	private $locale = "en-us";	
	private $session;
	private $params;
	private $path_info;
	private $uri;
	private $method;

	public function __construct() {
		$this->params = array();
	}

	public function add_param($key, $value) {
		$this->params[$key] = $value;
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
