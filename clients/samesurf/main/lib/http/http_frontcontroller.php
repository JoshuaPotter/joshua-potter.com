<?php

class http_frontcontroller {

	public static function route($routes, $request) {

		$components = explode('/', $_SERVER['PATH_INFO']);
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

				$params[$key] = $value;
			}
		}
	
		$controller = new $routes[$controllername];

		if (!method_exists($controller, $action)) {
			$action = "default_action";		
		}

		$request->params = $params;

		$controller->$action($request);
	}

}


?>
