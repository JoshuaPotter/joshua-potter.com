<?php

class module_auth implements core_eventhandler {

	protected $mappings;
	protected $login_url;
	
	public function __construct($mappings, $login_url, $verify_url) {
		$this->mappings = $mappings;
		$this->login_url = $login_url;
		$this->verify_url = $verify_url;
	}

	public function process($event) {

		$request = $event->in;
		$response = $event->out; 
		$requires_auth = false;

		foreach($this->mappings as $mapping) {
			if (preg_match($mapping, $request->uri) == 1) {
				$requires_auth = true;
				break;	
			}
		}

		if ($requires_auth) {
			if (!$request->session->has_auth()) {
				$request->uri = $this->login_url;
				$request->path_info = $this->login_url;
			}
			else {
				if (!$request->session->has_verified()) {
					$request->uri = $this->verify_url;
					$request->path_info = $this->verify_url;		
				}
			}
		}

		$event->handled = false;
	}

}
