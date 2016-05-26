<?php

class core_log {

	protected $stream;

	public static function instance() {
        static $instance = null;
        if ($instance === null) {
            $instance = new core_log();
        }
        return $instance;
    }

    private function __construct() {
		$this->stream = fopen('php://stdout', 'w');
    }

	public function init() {
	}
		
	public function set_stream($stream) {
		$this->$stream = $stream;
	}

	public function log($message) {
		if (!is_scalar($message)) {
			ob_start();
		 	print_r($message);
			$message = ob_get_clean();
		}
		fwrite($this->stream, "$message\n");
	}
}

function gf_log($m) {
	core_log::instance()->log($m);
}

