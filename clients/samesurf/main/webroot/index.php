<?php
	
	error_reporting(-1);
	
	$cwd = getcwd();
	$libpath = $cwd . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR;
	
	ini_set('include_path', $libpath);
	ini_set('short_open_tag', 1);
	
	$URI = $_SERVER['REQUEST_URI'];

	$PATH_INFO = null;
	if (isset($_SERVER['PATH_INFO'])) {
		$PATH_INFO = $_SERVER['PATH_INFO'];
	}

    if ($PATH_INFO == null) {
        $PATH_INFO = $URI;
    }   

	spl_autoload_register(function ($class) {
		$path = explode("_", $class);
		array_pop($path);
		$path = join(DIRECTORY_SEPARATOR, $path);
   		include  $path . DIRECTORY_SEPARATOR. $class . '.php';
	});

	core_log::instance()->init();
	
	core_config::instance()->set("db", array(
									"host" => "localhost",
									"database" => "samesurf_frontend",
									"username" => "frontend",
									"password" => "R0@st1Pig!"
							)
	);


	$static = new module_static();
	$session = new module_session();

	$mappings = array('/^\/account.*/', 
					  '/^\/domain.*/',
					  '/^\/signup\/step2/'
					);

	$auth = new module_auth($mappings, "/login", "/signup/step2");

	$routes = array(
			"default" => "webcontroller_default",
			"pages" => "webcontroller_pages",
			"register" => "webcontroller_register",
			"signup" => "webcontroller_signup",
			"account" => "webcontroller_account",
			"login" => "webcontroller_login",
			"logout" => "webcontroller_logout",
			"domain" => "webcontroller_domain"
	);
	$frontcontroller = new module_frontcontroller($routes);


	$eventmanager = new core_eventmanager(); 
	
	$eventmanager->add_event_handler("http_request", $static); 
	$eventmanager->add_event_handler("http_request", $session); 
	$eventmanager->add_event_handler("http_request", $auth);
	$eventmanager->add_event_handler("http_request", $frontcontroller); 


	$request = new http_request();
	$request->locale = "en-us";
	$request->uri = $URI;
	$request->path_info = $PATH_INFO;
	$request->method = $_SERVER['REQUEST_METHOD'];

	//foreach($_GET as $key => $value) {
	//	$request->add_param($key, $value);
	//}

	foreach($_POST as $key => $value) {
		$request->add_param($key, $value);
	}

	$requestevent = new core_event("http_request");
	$requestevent->in = $request;
	$requestevent->out = new http_response();

	$eventmanager->run_event($requestevent);
	return $requestevent->out->out();

