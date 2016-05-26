<?php 

class webcontroller_signup extends http_controller {


	public function default_action($request, $response) {
		$this->step1_action($request, $response);
	}	


	public function step1_action($request, $response) {
		if ($_SERVER['REQUEST_METHOD'] == "GET") {
			$this->step1_get_action($request, $response);
		}
		else {
			$this->step1_post_action($request, $response);
		}
	}

	/* step 1 get */
    public function step1_get_action($request, $response, $defaults = array(), $errors = array()) {

		if ($request->session->has_auth()) {
			$response->add_header('Location', '/account') ;
		}
		else {
        	$view = new http_view($request->locale); 
			$view->setParams($defaults);
			$view->setErrors($errors);
			$view->setLayout("views/login_layout.phtml");
			$view->setBlock("main", "views/signup_step1.phtml");
			$response->append_body($view->render());
		}
    }

	public function step1_post_action($request, $response) {
		$first_name = $_POST["first_name"];
		$last_name = $_POST["last_name"];
		$email = $_POST["email"];
		$location = $_POST["location"];
		$organization = $_POST["company"];
		$password = $_POST["password"];

		try {
			if (!util_validate::email($email)) {
				$this->step1_get_action($request, $response, 
						array(
							"email" => $email, 
							"password" => $password,
							"first_name" => $first_name,
							"last_name" => $last_name,
							"location" => $location,
							"company" => $organization
						), array("email" => "email_invalid"));
			}		
			else {
				$account = model_account::create($email, $password);
				$metadata = new stdClass(); 
				$metadata->first_name = $first_name;
				$metadata->last_name = $last_name;
				$metadata->location = $location;
				$metadata->organization = $organization;
				
				$account_metadata = model_accountmetadata::get($account->id());
				$account_metadata->set_metadata($metadata, $account->id());
				
				$token = $account->generate_validate_token();
				
				$content = new http_view($request->locale);
				$content->setLayout("views/email_registration_confirmation.phtml");
				$content->setParams(array("confirmationlink" => "http://" . $_SERVER['HTTP_HOST'] . "/signup/validate/token/$token"));
				$text = $content->render();

				message_smtp::send($email, "samesurf <support@samesurf.com>", "samesurf signup", $text);

				$request->session->grant_auth($account);
	
				// move to register/confirmation to prevent repost
				$response->add_header('Location', '/signup/step2') ;
			}
		}
		catch (exception_mysqlduplicate $e) {
			$this->step1_get_action($request, $response, 
					array(
						"email" => $email, 
						"password" => $password,
						"first_name" => $first_name,
						"last_name" => $last_name
					), array("email" => "email_in_use"));
		} 
		catch (Exception $e) {
			gf_log($e);
		}
	}

	public function step2_action($request, $response) {
		if ($_SERVER['REQUEST_METHOD'] == "GET") {
			$this->step2_get_action($request, $response);
		}
		else {
			$this->step2_post_action($request, $response);
		}
	}

    public function step2_get_action($request, $response, $defaults = array(), $errors = array()) {
		if ($request->session->has_verified()) {
			$response->add_header('Location', '/account') ;
		}
		else {
			$defaults["email"] = $request->session->account->email();
        	$view = new http_view($request->locale); 
			$view->setParams($defaults);
			$view->setErrors($errors);
			$view->setLayout("views/default_layout.phtml");
			$view->setBlock("main", "views/signup_step2.phtml");
			$response->append_body($view->render());
		}
    }
	

	// resend email
	public function step2_post_action($request, $response, $defaults = array(), $errors = array()) {
		
        if ($request->session->has_verified()) {
			$response->add_header('Location', '/account') ;
		}
		else {
		
			$email = $request->session->account->email();		
			$account = $request->session->account;
			$token = $account->generate_validate_token();
				
			$content = new http_view($request->locale);
			$content->setLayout("views/email_registration_confirmation.phtml");
			$content->setParams(array("confirmationlink" => "http://" . $_SERVER['HTTP_HOST'] . "/signup/validate/token/$token"));
			$text = $content->render();

			message_smtp::send($email, "samesurf <support@samesurf.com>", "samesurf signup", $text);

			$response->add_header('Location', '/signup/step2') ;
		}
    }

	public function validate_action($request, $response, $defaults = array(), $errors = array()) {
		$token = $request->params["token"];
		if (isset($token) && model_account::validate_validate_token($token)) {
			$response->add_header('Location', '/account') ;
		}
		else {
			$response->add_header('Location', '/error') ;
		}
	}
	
	public function invite_action($request, $response) {
		if ($_SERVER['REQUEST_METHOD'] == "GET") {
			$this->invite_get_action($request, $response);
		}
		else {
			$this->invite_post_action($request, $response);
		}
	}

	public function invite_get_action($request, $response, $defaults = array(), $errors = array()) {
		
		$view = new http_view($request->locale); 
		$view->setParams($defaults);
		$view->setErrors($errors);
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "views/validate_invite.phtml");
		$response->append_body($view->render());
	}
	
	public function invite_post_action($request, $response) {
		$token = $request->params["token"];
		$first_name = $_POST["first_name"];
		$last_name = $_POST["last_name"];
		$password = $_POST["password"];
 		$account = model_account::validate_validate_token($token);
		if (isset($token) && $account) {
 			$account->reset_password($password);
 			$request->session->grant_auth($account);
 			
 			$metadata = new stdClass(); 
			$metadata->first_name = $first_name;
			$metadata->last_name = $last_name;

			$account_metadata = model_accountmetadata::get($account->id());
			$account_metadata->set_metadata($metadata, $account->id());

			$response->add_header('Location', '/account') ;
		}else{
			$response->add_header('Location', '/error') ;
		}
	}
}
