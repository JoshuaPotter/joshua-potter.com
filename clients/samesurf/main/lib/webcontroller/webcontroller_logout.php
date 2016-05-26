<?php 

class webcontroller_logout extends http_controller {

	public function default_action($request, $response) {
		$this->default_get_action($request, $response);
	}

    public function default_get_action($request, $response, $defaults = array(), $errors = array()) {
		setcookie("names", "", time(), "/");
		$request->session->delete();	
		$response->add_header('Location', '/login') ;
    }

}
