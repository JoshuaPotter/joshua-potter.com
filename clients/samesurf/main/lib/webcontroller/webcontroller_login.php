<?php 

class webcontroller_login extends http_controller {

	public function default_action($request, $response) {
		if ($request->method == "GET") {
			$this->default_get_action($request, $response);
		}
		else {
			$this->default_post_action($request, $response);
		}
	}

    public function default_get_action($request, $response, $defaults = array(), $errors = array()) {

		if ($request->session->has_auth()) {
			$response->add_header('Location', '/account') ;
		}
		else {
        	$view = new http_view($request->locale); 
			$view->setParams($defaults);
			$view->setErrors($errors);
// 			$view->setLayout("views/default_layout.phtml");
// 			$view->setBlock("main", "views/login_default.phtml");
		    $view->setLayout("views/login_layout.phtml");
		    $view->setBlock("main", "views/login_default.phtml");
		    
			$response->append_body($view->render());
		}
    }

	public function default_post_action($request, $response) {

gf_log("login post");

		$email = $request->params["email"];
		$password = $request->params["password"];

		try {
			if (!util_validate::email($email)) {
				$this->default_get_action($request, array("email" => $email, "password" => $password), array("email" => "Please enter a valid email address"));
			}		
			else {
				$account = model_account::get_by_email($email);
				if ($account && $account->validate_password($password)) {
					if ($account->validate_confirmed()) {
						$request->session->grant_auth($account);
						$response->add_header('Location', '/account');
					}
					else {
						$response->add_header('Location', '/signup/step2');
					}
				}
				else {
					$this->default_get_action($request, $response, array("email" => $email, "password" => $password), array("email" => "login_error"));
				}
			}
		}
		catch (exception_mysqlduplicate $e) {
			$this->default_get_action($request, $response, array("email" => $email, "password" => $password), array("email" => "login_error"));
		} 
		catch (Exception $e) {
			gf_log("log of the exception");
			gf_log($e);
		}
	}

	public function reset_action($request, $response) {
		if ($_SERVER['REQUEST_METHOD'] == "GET") {
			$this->reset_get_action($request, $response);
		}
		else {
			$this->reset_post_action($request, $response);
		}
	}

	public function reset_get_action($request, $response, $defaults = array(), $errors = array()) {
        $view = new http_view($request->locale); 
		$view->setParams($defaults);
		$view->setErrors($errors);
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "views/login_reset.phtml");
		$response->append_body($view->render());
    }

	public function reset_post_action($request, $response, $defaults = array(), $errors = array()) {

		$email = $_POST["email"];

		try {
			if (!util_validate::email($email)) {
				$this->default_get_action($request, $response, array("email" => $email, "password" => $password), array("email" => "Please enter a valid email address"));
			}		
			else {
				$account = model_account::get_by_email($email);
				$token = $account->generate_password_reset_token($email);
			
				$content = new http_view($request->locale);
				$content->setLayout("views/email_login_reset.phtml");
				$content->setParams(array("resetlink" => "http://127.0.0.1/login/resetform/token/$token"));
				$text = $content->render();

				message_smtp::send($email, "samesurf <support@samesurf.com>", "samesurf password reset", $text);
				$response->add_header('Location', '/login/resetstep2') ;
			}
		}
		catch (Exception $e) {
			echo $e;
		}
    }
    
    public function resetstep2_action($request, $response) {
		if ($_SERVER['REQUEST_METHOD'] == "GET") {
			$this->resetstep2_get_action($request, $response);
		}
		else {
			$this->resetstep2_post_action($request, $response);
		}
	}
	
	public function resetstep2_get_action($request, $response) {

		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "views/login_resetstep2.phtml");
		
		$response->append_body($view->render());
    }
	    
	public function resetform_action($request, $response) {
		if ($_SERVER['REQUEST_METHOD'] == "GET") {
			$this->resetform_get_action($request, $response);
		}
		else {
			$this->resetform_post_action($request, $response);
		}
	}

	public function resetform_get_action($request, $response, $defaults = array(), $errors = array()) {
        $view = new http_view($request->locale); 
		$view->setParams($defaults);
		$view->setErrors($errors);
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "views/login_resetform.phtml");
		$response->append_body($view->render());
    }

	public function resetform_post_action($request, $response, $defaults = array(), $errors = array()) {

		$password = $_POST["password"];
		$token = $request->params["token"];

		try {
			$account = model_account::validate_password_reset_token($token);
			if ($account) {
					$account->reset_password($password);
					$request->session->grant_auth($account);
					$response->add_header('Location', '/account');
			}
			else {
					echo "invalid";
			}
		}
		catch (Exception $e) {
			echo $e;
		}
    }
}
