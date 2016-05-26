<?php

class core_config {

	protected $settings;

	public static function instance() {
        static $instance = null;
        if ($instance === null) {
            $instance = new core_config();
        }
        return $instance;
    }

    private function __construct() {
			$this->settings = array();
    }
		
	
	public function set($key, $value) {
		$this->settings[$key] = $value;
	}

	public function get($key) {
		return $this->settings[$key];
	}
		
}




