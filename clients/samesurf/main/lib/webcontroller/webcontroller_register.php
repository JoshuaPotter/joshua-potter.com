<?php 

class webcontroller_register extends http_controller {

	public function default_action($request, $response) {
		if ($_SERVER['REQUEST_METHOD'] == "GET") {
			$this->default_get_action($request, $response);
		}
		else {
			$this->default_post_action($request, $response);
		}
	}

    public function default_get_action($request, $response, $defaults = array(), $errors = array()) {
        $view = new http_view($request->locale); 
		$view->setParams($defaults);
		$view->setErrors($errors);
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "views/register_default.phtml");
		$response->append_body($view->render());
    }

	public function confirmation_action($request, $response,  $defaults = array(), $errors = array()) {
        $view = new http_view($request->locale); 
		$view->setParams($defaults);
		$view->setErrors($errors);
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "views/register_confirmation.phtml");
		$response->append_body($view->render());
    }

	public function validate_action($request, $response, $defaults = array(), $errors = array()) {
		$token = $request->params["token"];
		if (isset($token) && model_account::validate_validate_token($token)) {
			$response->append_body("token validated ok = account now active");
		}
		else {
			$response->append_body("token not validate");
		}
	}

	public function default_post_action($request, $response) {

		$email = $_POST["email"];
		$password = $_POST["password"];

		try {
			if (!util_validate::email($email)) {
				$this->default_get_action($request, $response, array("email" => $email, "password" => $password), array("email" => "Please enter a valid email address"));
			}		
			else {
				$account = model_account::create($email, $password);
				$token = $account->generate_validate_token();
				
				$content = new http_view($request->locale);
				$content->setLayout("views/email_registration_confirmation.phtml");
				$content->setParams(array("confirmationlink" => "http://192.168.1.101/register/validate/token/$token"));
				$text = $content->render();

				message_smtp::send($email, "samesurf <support@samesurf.com>", "samesurf signup", $text);
	
				// move to register/confirmation to prevent repost
				$response->add_header('Location', 'register/confirmation') ;
			}
		}
		catch (exception_mysqlduplicate $e) {
			$this->default_get_action($request, $response, array("email" => $email, "password" => $password), array("email" => "This address is already in use"));
		} 
		catch (Exception $e) {
			gf_log($e);
		}
	}
}
