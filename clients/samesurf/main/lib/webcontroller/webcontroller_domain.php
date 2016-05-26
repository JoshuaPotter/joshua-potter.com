<?php

class webcontroller_domain {

    public function default_action($request, $response) {
        $view = new http_view($request->locale); 

		$domains = model_domain::get_all_by_access($request->session->accountid());
		$params = array("domains" => $domains);
		$view->setParams($params);
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "views/domain_default.phtml");
		$response->append_body($view->render());
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
		$view->setParams($defaults);
		$view->setErrors($errors);
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "views/domain_add.phtml");
		$response->append_body($view->render());
    }

	public function add_post_action($request, $response) {

		$domain = $request->params["domain"];
		if ($domain != "") {
			$accountid = $request->session->accountid();
			$domain = model_domain::create($domain, $accountid);
			$response->add_header("Location", "default");
		}
		else {
			$this->add_get_action($request, $response, array("domain" => $domain), array("domain", "please enter a valid domain"));
		}
	}

	public function listaccess_action($request, $response) {
		$publicid = $request->params["pid"];
		$domain = model_domain::get_by_publicid($publicid);	

		if ($domain->has_access($request->session->accountid())) {
			$access = $domain->list_access();
			$view = new http_view($request->locale); 
			$view->setParams(array("domain" => $domain, "access" => $access));
			$view->setErrors($errors);
			$view->setLayout("views/default_layout.phtml");
			$view->setBlock("main", "views/domain_listaccess.phtml");
			$response->append_body($view->render());
		}
		else {
			$response->add_header("Location", "login");
		}
	}


	public function addaccess_action($request, $response) {
		if ($request->method == "GET") {
			$this->addaccess_get_action($request, $response);
		}
		else {
			$this->addaccess_post_action($request, $response);
		}
	}
	
	public function addaccess_get_action($request, $response) {
		$publicid = $request->params["pid"];
		$domain = model_domain::get_by_publicid($publicid);	

		if ($domain->has_access($request->session->accountid())) {
			$view = new http_view($request->locale); 
			$view->setLayout("views/default_layout.phtml");
			$view->setBlock("main", "views/domain_addaccess.phtml");
			$response->append_body($view->render());
		}
		else {
			$response->add_header("Location", "login");
		}

	}

	public function addaccess_post_action($request, $response) {
		$publicid = $request->params["pid"];
		$new_email = $request->params["email"];
		$domain = model_domain::get_by_publicid($publicid);	

		if ($domain->has_access($request->session->accountid())) {
	
			$account = model_account::get_by_email($new_email);
			//account exists so add it
			if ($account) {
				$domain->grant_access($account->id());
			}	
			else {
				// asked to add	
			}
			$response->add_header("Location", "/domain/listaccess/pid/$publicid");
		}
		else {
			$response->add_header("Location", "login");
		}
	}

	public function removeaccess_action($request, $response) {
		
		$publicid = $request->params["pid"];
		$id = $request->params["id"];
		$domain = model_domain::get_by_publicid($publicid);	

		if ($request->method == "GET") {
			if ($domain->has_access($request->session->accountid())) {
				$toremove = $request->params["id"]; 
				$domain->revoke_access($id);
				$response->add_header("Location", "/domain/listaccess/pid/$publicid");
			}
			else {
				$response->add_header("Location", "login");
			}
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
			$view->setBlock("main", "views/domain_listconfig.phtml");
			$response->append_body($view->render());
		}
		else {
			$response->add_header("Location", "login");
		}

	}

	public function config_post_action($request, $response) {
		$publicid = $request->params["pid"];
		$domain = model_domain::get_by_publicid($publicid);	

		if ($domain->has_access($request->session->accountid())) {
			$config = $domain->get_config();
			
			foreach ($config->bool_setting as $bool_setting) {
				if (isset($request->params[$bool_setting->key])) {
					$bool_setting->value = true;
				}
			}
			$domain->set_config($config);
			$response->add_header("Location", "/account/config/pid/$publicid");
		}
		else {
			$response->add_header("Location", "login");
		}
	}

}
