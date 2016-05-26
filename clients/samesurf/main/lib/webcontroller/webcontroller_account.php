<?php 

class webcontroller_account extends http_controller {

    public function default_action($request, $response, $defaults = array(), $errors = array()) {
		$view = new http_view($request->locale); 
		
		$domains = model_domain::get_all_by_access($request->session->accountid());
		$defaults["domains"] = $domains;
		$defaults["details"] = $request->session->account_metadata;
		$defaults["email"] = $request->session->account->email();
		
		gf_log($request);
		
		$view->setParams($defaults);
		$view->setErrors($errors);
		$view->setLayout("views/default_layout.phtml");
		if($request->session->account->tut_complete()){
			$view->setBlock("main", "views/account_default.phtml");
		}else{
			$view->setBlock("main", "views/account_start.phtml");
		}
		$response->append_body($view->render());
    }

	public function updatedetails_action($request, $response) {
		if ($request->method == "GET") {
			$this->updatedetails_get_action($request, $response);
		}
		else {
			$this->updatedetails_post_action($request, $response);
		}
	}


    public function updatedetails_get_action($request, $response, $defaults = array(), $errors = array()) {
        $view = new http_view($request->locale); 
		$view->setParams($defaults);
		$view->setErrors($errors);
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "views/account_updatedetails.phtml");
		$response->append_body($view->render());
    }

	public function updatedetails_post_action($request, $response) {

		$metadata = new stdClass(); 
		$metadata->first_name = $request->params["first_name"];
		$metadata->last_name = $request->params["last_name"];
		$metadata->location = $request->params["location"];
		$metadata->organization = $request->params["company"];

		$accountid = $request->session->accountid();
		$account_metadata = model_accountmetadata::get($accountid);
		$account_metadata->set_metadata($metadata, $accountid);
		
		$request->session->set_details($metadata->first_name, $metadata->last_name);
		
		$response->add_header("Location", "default");
	}

	public function add_action($request, $response) {
		if ($request->method == "GET") {
			$this->add_get_action($request, $response);
		}
		else {
			$this->add_post_action($request, $response);
		}
	}
	
	public function add_get_action($request, $response, $defaults = array(), $errors = array()) {
		$view = new http_view($request->locale);
		
		$domains = model_domain::get_all_by_access($request->session->accountid());
		$defaults["domains"] = $domains;
		
		$view->setParams($defaults);
		$view->setErrors($errors);
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("progress","views/progress_bar/step_1.phtml");
		$view->setBlock("main", "views/account_add.phtml");
		$response->append_body($view->render());
	}

	public function add_post_action($request, $response) {
		$domain = $request->params["domain"];
		if ($domain != "") {
			$accountid = $request->session->accountid();
			$domain = model_domain::create($domain, $accountid);
			$response->add_header("Location","/account/auth/pid/" . $domain->publicid());
		}
		else {
			$this->add_get_action($request, $response, array("domain" => $domain), array("domain", "please enter a valid domain"));
		}
	}
	
	public function remove_action($request, $response) {
		if ($request->method == "GET") {
			$response->add_header("Location", "/account");
		}
		else {
			$this->remove_post_action($request, $response);
		}
	}

	public function remove_post_action($request, $response) {
		$publicid = $_POST["pid"];
		$domain = model_domain::get_by_publicid($publicid);	

		if ($domain->has_access($request->session->accountid())) {
			$domain->delete();
			$response->add_header("Location", "/account");
		}
		else {
			$response->add_header("Location", "/login");
		}
	}



	public function config_action($request, $response) {
		if ($request->method == "GET") {
			$this->config_get_action($request, $response);
		}
		else {
			$this->config_post_action($request, $response);
		}
	}

	public function config_get_action($request, $response) {
		
		$publicid = $request->params["pid"];
		$domain = model_domain::get_by_publicid($publicid);	

		if ($domain->has_access($request->session->accountid())) {
			$view = new http_view($request->locale); 
			$view->setParams(array("domain" => $domain));
			$view->setLayout("views/default_layout.phtml");
			$view->setBlock("progress", "views/progress_bar/step_3.phtml");
			$view->setBlock("main", "views/account_listconfig.phtml");
			$response->append_body($view->render());
		}
		else {
			$response->add_header("Location", "/login");
		}

	}

	public function config_post_action($request, $response) {
		$publicid = $request->params["pid"];
		$domain = model_domain::get_by_publicid($publicid);	
		
		gf_log($request->params);
		
		if ($domain->has_access($request->session->accountid())) {
			$config = $domain->get_config();

			foreach ($config->bool_setting as $bool_setting) {
				if (isset($request->params[$bool_setting->key])) {
					$bool_setting->value = true;
				}
			}
			if (isset($request->params["button_location"])) {
				foreach ($config->button_setting as $button_setting) {
					if($button_setting->configkey == "button_location"){
						$button_setting->configvalue = $request->params["button_location"];
					}
				}
			}
			if (isset($request->params["button_color"])) {
				foreach ($config->button_setting as $button_setting) {
					if($button_setting->configkey == "button_color"){
						$button_setting->configvalue = $request->params["button_color"];
					}
				}
			}
			if (isset($request->params["logo"])) {
				foreach ($config->logo_setting as $logo_setting) {
					if($logo_setting->configkey == "location"){
						$logo_setting->configvalue = "ui/images/default_images/" . $request->params["logo"];
					}
				}
			}
			
			$domain->set_config($config);
			$response->add_header("Location", "/account/code/pid/$publicid");

		}
		else {
			$response->add_header("Location", "/login");
		}
	}

	public function auth_action($request, $response) {
		if ($request->method == "GET") {
			$this->auth_get_action($request, $response);
		}
		else {
			$this->auth_post_action($request, $response);
		}
	}

	public function auth_get_action($request, $response) {
		
		$publicid = $request->params["pid"];
		$domain = model_domain::get_by_publicid($publicid);	

		if ($domain->has_access($request->session->accountid())) {
			$view = new http_view($request->locale); 
			$view->setParams(array("domain" => $domain));
			$view->setLayout("views/default_layout.phtml");
 			$view->setBlock("progress", "views/progress_bar/step_2.phtml");
			$view->setBlock("main", "views/account_auth.phtml");
			$response->append_body($view->render());
		}
		else {
			$response->add_header("Location", "/login");
		}

	}

	public function auth_post_action($request, $response) {
		$publicid = $request->params["pid"];
		$type = $request->params["type"];
		$domain = model_domain::get_by_publicid($publicid);	
		if ($domain->has_access($request->session->accountid())) {

			if ($type == "domain") {
				$allowed = $_POST["allowed"];
				$domain->authorize_domain($allowed);
				$response->add_header("Location", "/account/config/pid/$publicid");
			}
			else if ($type == "user") {
				$allowed = $_POST["allowed"];		
				$account = model_account::get_by_email($allowed);
				if ($account) {
					$domain->grant_access($account->id());
				}else{
					try {
 						$email = $allowed;
 						$password = "password";

						$account = model_account::create($email,$password);
						
						$token = $account->generate_validate_token();
						$content = new http_view($request->locale);
						$content->setLayout("views/email_registration_invitation.phtml");
						$content->setParams(array("confirmationlink" => "http://" . $_SERVER['HTTP_HOST'] . "/signup/invite/token/$token", "domain" => $domain->domain()));
						$text = $content->render();
		
						message_smtp::send($email, "samesurf <support@samesurf.com>", "samesurf signup", $text);

						$domain->grant_access($account->id());
					}
					catch (exception_mysqlduplicate $e) {
						gf_log($e);
					} 
					catch (Exception $e) {
						gf_log($e);
					}
				}
				$response->add_header("Location", "/account/auth/pid/$publicid");
			}
		}
		else {
			$response->add_header("Location", "/login");
		}
	}
	
	
	public function deauth_action($request, $response) {
		$publicid = $request->params["pid"];
		$type = $request->params["type"];
		$domain = model_domain::get_by_publicid($publicid);	
		
		if ($domain->has_access($request->session->accountid())) {
			if ($type == "domain") {
				$remove = $_POST["remove"];
				$domain->deauthorize_domain($remove);
				$response->add_header("Location", "/account/config/pid/$publicid");
			}
			else if ($type == "user") {
				$remove = $_POST["remove"];	
				$account = model_account::get_by_email($remove);
				if ($account) {
					$domain->revoke_access($account->id());
				}
				$response->add_header("Location", "/account/auth/pid/$publicid");
			}

			
		}
		else {
			$response->add_header("Location", "/login");
		}
	}

	public function code_action($request, $response) {
		
		if ($request->method == "GET") {
			$this->code_get_action($request, $response);
		}
		else {
			$this->code_post_action($request, $response);
		}
	}
		
	public function code_get_action($request, $response) {
		$publicid = $request->params["pid"];
		$domain = model_domain::get_by_publicid($publicid);	

		if ($domain->has_access($request->session->accountid())) {
			$view = new http_view($request->locale); 
			$view->setParams(array("domain" => $domain));
			$view->setLayout("views/default_layout.phtml");
			$view->setBlock("progress", "views/progress_bar/step_4.phtml");
			$view->setBlock("main", "views/account_code.phtml");
			$response->append_body($view->render());
		}
		else {
			$response->add_header("Location", "/login");
		}

	}
	
	public function code_post_action($request, $response) {
		
		$request->session->account->tut_complete_complete();	

		$response->add_header("Location", "/account");

	}
	
	public function instructions_action($request, $response, $defaults = array(), $errors = array()) {
		$view = new http_view($request->locale); 
		
		$domains = model_domain::get_all_by_access($request->session->accountid());
		$defaults["domains"] = $domains;
		
		$view->setParams($defaults);
		$view->setErrors($errors);
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "views/account_instructions.phtml");
		$response->append_body($view->render());
    }


}
