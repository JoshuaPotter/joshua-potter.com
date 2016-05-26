<?php

class module_frontcontroller implements core_eventhandler {

	protected $routes;
	
	public function __construct($routes) {
		$this->routes = $routes;
	}

	public function process($event) {

		$request = $event->in;
		$response = $event->out; 
	
		$components = explode('/', $request->path_info);

		$controllername = "";
		$action = "";

		if (isset($components[1]) && $components[1] != "") {
			$controllername = $components[1];
		}

		if (isset($components[2]) && $components[2] != "") {
			$action = $components[2] . "_action";
		}

		$params = array();

		for ($i = 3; $i < count($components); $i += 2) {
			if (isset($components[$i]) && $components[$i] != "") {
				$key = $components[$i];
				$value = "";

				if (isset($components[$i + 1]) && $components[$i + 1] != "") {
					$value = $components[$i + 1];
				}

				$request->add_param($key, $value);
			}
		}

		$controller = new webcontroller_default();
		if (isset($this->routes[$controllername])) {
			$controller = new $this->routes[$controllername];
		}

		if (!method_exists($controller, $action)) {
			$action = "default_action";		
		}

		$controller->$action($request, $response);

		$event->handled = true;

	}

}
