<?php

class module_session implements core_eventhandler {

	public function __construct() {
	}

	public function process($event) {
		$request = $event->in;
		$http_session = new http_session();
		$http_session->process($request);

		$event->handled = false;
	}

}
