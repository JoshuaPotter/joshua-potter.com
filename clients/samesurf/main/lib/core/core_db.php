<?php

class core_db {

	protected $db;

	public static function instance() {
        static $instance = null;
        if ($instance === null) {
            $instance = new core_db();
        }
        return $instance;
    }

    private function __construct() {
	
		$settings = core_config::instance()->get("db");
		$host = $settings["host"];
		$database =  $settings["database"];
		$user = $settings["username"];
		$pass = $settings["password"];

		$this->db = new PDO("mysql:host=$host;dbname=$database", $user, $pass, array(
   			PDO::ATTR_PERSISTENT => true
		));

    }

	public function get() {
		return $this->db;
	}
		
}




