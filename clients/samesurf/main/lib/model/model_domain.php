<?php

class model_domain {

	protected $domain;
	protected $publicid;
	protected $id;

	public function publicid() {
		return $this->publicid;
	}

	public function domain() {
		return $this->domain;
	}

	public static function create($domain, $accountid) {
	
		$db = core_db::instance()->get();

		try {
	
	    	$insert = $db->prepare("insert into domains set domain=:domain, owner_id=:owner_id, creation_date=UTC_TIMESTAMP()");	
			$insert->bindParam(":domain", $domain, PDO::PARAM_STR);
			$insert->bindParam(":owner_id", $accountid, PDO::PARAM_INT);

			if (!$insert->execute()) {
				gf_log($insert->errorInfo());
			}

			$id = $db->lastInsertId();
			$publicid = self::generate_public_id($id);

			$update = $db->prepare("update domains set publicid=:publicid where id=:id");
			$update->bindParam(":publicid", $publicid, PDO::PARAM_INT);
			$update->bindParam(":id", $id, PDO::PARAM_INT);
			$update->execute();

			$permissions = $db->prepare("insert into domain_access set domain_id=:domainid, account_id=:accountid");
			$permissions->bindParam(":domainid", $id, PDO::PARAM_INT);
			$permissions->bindParam(":accountid", $accountid, PDO::PARAM_INT);
			$permissions->execute();	


			$domain = new model_domain();
			$domain->id = $id;
			$domain->publicid = $publicid;
			$domain->domain = $domain;
				
			return $domain;

		}
		catch(Exception $e) {	
			return false;	
		}
	}


	protected static function generate_public_id($id) {
 		$publicid = (5915587277 * $id) % 2097593;
		return $publicid;
	}

	public static function get_by_id($id) {
		try {
			$db = core_db::instance()->get();

			$find = $db->prepare("select * from domains where id=:id");
			$find->bindParam(":id", $id, PDO::PARAM_INT);
			$find->execute();
			$result = $find->fetch(PDO::FETCH_OBJ);	
			
			$domain = new model_domain();
			$domain->id = $result->id;
			$domain->publicid = $result->publicid;

			return $domain;
		}
		catch (Exception $e) {
			return false;
		}
	}

	public static function get_by_publicid($id) {
		try {
			$db = core_db::instance()->get();

			$find = $db->prepare("select * from domains where publicid=:id");
			$find->bindParam(":id", $id, PDO::PARAM_INT);
			$find->execute();
			$result = $find->fetch(PDO::FETCH_OBJ);	
			
			$domain = new model_domain();
			$domain->id = $result->id;
			$domain->publicid = $result->publicid;
			$domain->domain = $result->domain;

			return $domain;
		}
		catch (Exception $e) {
			return false;
		}
	}

	public static function get_all_by_access($accountid) {
		try {
			$db = core_db::instance()->get();

			$find = $db->prepare("select * from domains where id in (select domain_id from domain_access where account_id=:accountid)");
			$find->bindParam(":accountid", $accountid, PDO::PARAM_INT);
			$find->execute();
			
			$domains = array();

			while ($result = $find->fetch(PDO::FETCH_OBJ)) {
				$domain = new model_domain();
				$domain->id = $result->id;
				$domain->publicid = $result->publicid;
				$domain->domain = $result->domain;
				array_push($domains, $domain);
			}

			return $domains;
		}
		catch (Exception $e) {
			return false;
		}
	}

	public function has_access($accountid) {
		try {
			$db = core_db::instance()->get();

			$find = $db->prepare("select * from domain_access where account_id=:accountid and domain_id=:id");
			$find->bindParam(":accountid", $accountid, PDO::PARAM_INT);
			$find->bindParam(":id", $this->id, PDO::PARAM_INT);
			if ($find->execute()) {
				$result = $find->fetch(PDO::FETCH_OBJ);
				if ($result) {
					return true;
				}
			}
			else {
				gf_log($find->errorInfo());
			}
			return false;
		}
		catch (Exception $e) {
			gf_log($e);
			return false;
		}

	}

	public function grant_access($accountid) {
		try {
			$db = core_db::instance()->get();
			$permissions = $db->prepare("insert into domain_access set domain_id=:domainid, account_id=:accountid");
			$permissions->bindParam(":domainid", $this->id, PDO::PARAM_INT);
			$permissions->bindParam(":accountid", $accountid, PDO::PARAM_INT);
			$permissions->execute();	
			return true;
		}
		catch(Exception $e) {
			gf_log($e);
			return false;
		}
	}

	public function revoke_access($accountid) { 
		try {
			$db = core_db::instance()->get();
			$permissions = $db->prepare("delete from domain_access where domain_id=:domainid and account_id=:accountid");
			$permissions->bindParam(":domainid", $this->id, PDO::PARAM_INT);
			$permissions->bindParam(":accountid", $accountid, PDO::PARAM_INT);
			$permissions->execute();	
			return true;
		}
		catch(Exception $e) {
			gf_log($e);
			return false;
		}

	}

	public function list_access() {
		try {
			$db = core_db::instance()->get();

			$find = $db->prepare("select accounts.id, accounts.email from accounts join domain_access on accounts.id = domain_access.account_id where domain_access.domain_id=:id;");
			$find->bindParam(":id", $this->id, PDO::PARAM_INT);
			$find->execute();

			$access_list = array();

			while ($result = $find->fetch(PDO::FETCH_OBJ)) {
				$account = new stdClass();
				$account->email = $result->email;
				$account->id = $result->id;
				array_push($access_list, $account);
			}

			return $access_list;
		}
		catch (Exception $e) {
			gf_log($e);
			return false;
		}

	}

    public function get_config() {
		try {
			$db = core_db::instance()->get();

//
//	Boolean settings
//

			//$find = $db->prepare("select * from available_client_settings where private=0 and type=:type");
			$find = $db->prepare("select a.id, a.setting_key, a.name, a.description, a.private, b.setting_value from available_client_settings a left join bool_default_settings b on a.id=b.setting_key where private NOT IN (2) and type=:type");
			$find->bindValue(":type", "bool", PDO::PARAM_STR);
			$find->execute();

			$config = new stdClass();
			$config->bool_setting = array();
			$config->button_setting = array();
			$config->color_setting = array();
			$config->logo_setting = array();
			$config->string_client_setting = array();
			$config->int_client_setting = array();
			$config->template_setting = array();

			while ($result = $find->fetch(PDO::FETCH_OBJ)) {
				$setting = new stdClass();
				$setting->key = $result->id;
				$setting->name = $result->name;
				$setting->description = $result->description;
				$setting->value = false;
				$setting->private = $result->private;
				if ($result->setting_value == 1) {
					$setting->value = true;
				}
				array_push($config->bool_setting, $setting);
			}

			$bool = $db->prepare("select * from available_client_settings a left join bool_client_settings b on a.id = b.setting_key where a.private=0 and a.type=:type and b.domain_id=:id");
			$bool->bindParam(":id", $this->id, PDO::PARAM_INT);
			$bool->bindValue(":type", "bool", PDO::PARAM_STR);
			$bool->execute();

			while ($result = $bool->fetch(PDO::FETCH_OBJ)) {
				foreach ($config->bool_setting as $setting) {
					if ($result->setting_key == $setting->key) {
						$setting->value = $result->setting_value;
					}
				}
			}
			
//
//	button settings
//

			try {
			
				$find = $db->prepare("select configkey, configvalue from buttons where domain=:pid");
				$find->bindParam(":pid", $this->id, PDO::PARAM_INT);
				$find->execute();
				
				gf_log("select configkey, configvalue from buttons where domain=:pid");
				while ($result = $find->fetch(PDO::FETCH_OBJ)) {
					$setting = new stdClass();
					$setting->configkey = $result->configkey;
					$setting->configvalue = $result->configvalue;

					array_push($config->button_setting, $setting);
				}	
				if(empty($config->button_setting)){
					gf_log("select * from default_buttons");
					$find = $db->prepare("select * from default_buttons");
					$find->execute();
					
					while ($result = $find->fetch(PDO::FETCH_OBJ)) {
						$setting = new stdClass();
						$setting->configkey = $result->configkey;
						$setting->configvalue = $result->configvalue;
						
						array_push($config->button_setting, $setting);
					}
				}
			}
			catch(Exception $e) {
				gf_log('thrown the Exception');
			}

//
//	color settings
//
			
			try {
			
				$find = $db->prepare("select configkey, configvalue from colors where domain=:pid");
				$find->bindParam(":pid", $this->id, PDO::PARAM_INT);
				$find->execute();
				
				gf_log("select configkey, configvalue from colors where domain=:pid");
				while ($result = $find->fetch(PDO::FETCH_OBJ)) {
					$setting = new stdClass();
					$setting->configkey = $result->configkey;
					$setting->configvalue = $result->configvalue;

					array_push($config->color_setting, $setting);
				}	
				if(empty($config->color_setting)){
					gf_log("select * from default_colors");
					$find = $db->prepare("select * from default_colors");
					$find->execute();
					
					while ($result = $find->fetch(PDO::FETCH_OBJ)) {
						$setting = new stdClass();
						$setting->configkey = $result->configkey;
						$setting->configvalue = $result->configvalue;
						
						array_push($config->color_setting, $setting);
					}
				}
			}
			catch(Exception $e) {
				gf_log('thrown the Exception');
			}

//
//	logo setting
//
		
			try {
			
				$find_logo = $db->prepare("select * from logo where domain=:pid");
				$find_logo->bindParam(":pid", $this->id, PDO::PARAM_INT);
				$find_logo->execute();
				
				gf_log("select * from logo where domain=:pid");
				while ($result_logo = $find_logo->fetch(PDO::FETCH_OBJ)) {
					$setting = new stdClass();
					$setting->configkey = $result_logo->configkey;
					$setting->configvalue = $result_logo->configvalue;

					array_push($config->logo_setting, $setting);
				}	
				if(empty($config->logo_setting)){
					gf_log("select * from default_logo");
					$find = $db->prepare("select * from default_logo");
					$find->execute();
					
					while ($result = $find->fetch(PDO::FETCH_OBJ)) {
						$setting = new stdClass();
						$setting->configkey = $result->configkey;
						$setting->configvalue = $result->configvalue;
						
						array_push($config->logo_setting, $setting);
					}
				}
			}
			catch(Exception $e) {
				gf_log('thrown the Exception');
			}
			
//
//	expanded menu setting
//
		
			try {
			
				$find = $db->prepare("select setting_key, setting_value from string_client_settings where domain=:pid");
				$find->bindParam(":pid", $this->id, PDO::PARAM_INT);
				$find->execute();
				
				gf_log("select setting_key, setting_value from string_client_settings where domain=:pid");
				while ($result = $find->fetch(PDO::FETCH_OBJ)) {
					$setting = new stdClass();
					$setting->setting_key = $result->setting_key;
					$setting->setting_value = $result->setting_value;

					array_push($config->string_client_setting, $setting);
				}	
				if(empty($config->string_client_setting)){
					gf_log("select * from string_default_settings");
					$find = $db->prepare("select * from string_default_settings");
					$find->execute();
					
					while ($result = $find->fetch(PDO::FETCH_OBJ)) {
						$setting = new stdClass();
						$setting->setting_key = $result->setting_key;
						$setting->setting_value = $result->setting_value;
						
						array_push($config->string_client_setting, $setting);
					}
				}
			}
			catch(Exception $e) {
				gf_log('thrown the Exception');
			}
			
//
//	int setting
//
		
			try {
			
				$find = $db->prepare("select setting_key, setting_value from int_client_settings where domain=:pid");
				$find->bindParam(":pid", $this->id, PDO::PARAM_INT);
				$find->execute();
				
				gf_log("select setting_key, setting_value from int_client_settings where domain=:pid");
				while ($result = $find->fetch(PDO::FETCH_OBJ)) {
					$setting = new stdClass();
					$setting->setting_key = $result->setting_key;
					$setting->setting_value = $result->setting_value;

					array_push($config->int_client_setting, $setting);
				}	
				if(empty($config->int_client_setting)){
					gf_log("select * from int_default_settings");
					$find = $db->prepare("select * from int_default_settings");
					$find->execute();
					
					while ($result = $find->fetch(PDO::FETCH_OBJ)) {
						$setting = new stdClass();
						$setting->setting_key = $result->setting_key;
						$setting->setting_value = $result->setting_value;
						
						array_push($config->int_client_setting, $setting);
					}
				}
			}
			catch(Exception $e) {
				gf_log('thrown the Exception');
			}
			
//
//	template setting
//
		
			try {
				gf_log("select * from default_templates");
				$find = $db->prepare("select * from default_templates");
				$find->execute();
				
				while ($result = $find->fetch(PDO::FETCH_OBJ)) {
					$setting = new stdClass();
					$setting->configkey = $result->configkey;
					$setting->configvalue = $result->configvalue;
					
					array_push($config->template_setting, $setting);
				}
			}
			catch(Exception $e) {
				gf_log('thrown the Exception');
			}



			return $config;

		}
		catch(Exception $e) {
			gf_log($e); 
			return false; 
		}

	}	

	public function set_config($config) {
		try {
			$db = core_db::instance()->get();

//
// Set Boolean
//

			$purge = $db->prepare("delete from bool_client_settings where domain_id=:pid");
			$purge->bindParam(":pid", $this->id, PDO::PARAM_INT);
			$purge->execute();

			$find = $db->prepare("insert into bool_client_settings set setting_value=:value, setting_key=:key, domain_id=:pid, creation_date=UTC_TIMESTAMP()");
			$bool_settings = $config->bool_setting;

			foreach ($bool_settings as $bool_setting) {
				$find->bindParam(":value", $bool_setting->value, PDO::PARAM_INT);
				$find->bindParam(":key", $bool_setting->key, PDO::PARAM_STR);
				$find->bindParam(":pid", $this->id, PDO::PARAM_INT);
				$find->execute();
			}

//
//	Set button
//
			
			$purge_button = $db->prepare("delete from buttons where domain=:pid");
			$purge_button->bindParam(":pid", $this->id, PDO::PARAM_INT);
			$purge_button->execute();
			
			$find_button = $db->prepare("insert into buttons set configkey=:configkey, configvalue=:configvalue, domain=:pid");
			$button_settings = $config->button_setting;
			
			foreach ($button_settings as $button_setting) {
				$find_button->bindParam(":configkey", $button_setting->configkey, PDO::PARAM_STR);
				$find_button->bindParam(":configvalue", $button_setting->configvalue, PDO::PARAM_STR);
				$find_button->bindParam(":pid", $this->id, PDO::PARAM_INT);
				$find_button->execute();
			}

//
//	Set colors
//
			
			$purge_color = $db->prepare("delete from colors where domain=:pid");
			$purge_color->bindParam(":pid", $this->id, PDO::PARAM_INT);
			$purge_color->execute();
			
			$find_color = $db->prepare("insert into colors set configkey=:configkey, configvalue=:configvalue, domain=:pid");
			$color_settings = $config->color_setting;
			
			foreach ($color_settings as $color_setting) {
				$find_color->bindParam(":configkey", $color_setting->configkey, PDO::PARAM_STR);
				$find_color->bindParam(":configvalue", $color_setting->configvalue, PDO::PARAM_STR);
				$find_color->bindParam(":pid", $this->id, PDO::PARAM_INT);
				$find_color->execute();
			}
			
//
//	Set logo
//
			
			$purge_logo = $db->prepare("delete from logo where domain=:pid");
			$purge_logo->bindParam(":pid", $this->id, PDO::PARAM_INT);
			$purge_logo->execute();
			
			$find_logo = $db->prepare("insert into logo set domain=:pid, configkey=:configkey, configvalue=:configvalue");
			$logo_settings = $config->logo_setting;
			
			foreach ($logo_settings as $logo_setting) {
				$find_logo->bindParam(":pid", $this->id, PDO::PARAM_INT);
				$find_logo->bindParam(":configkey", $logo_setting->configkey, PDO::PARAM_STR);
				$find_logo->bindParam(":configvalue", $logo_setting->configvalue, PDO::PARAM_STR);
				
				$find_logo->execute();
			}
			
//
//	Set expanded menu
//
			
			$purge_expanded_menu = $db->prepare("delete from string_client_settings where domain_id=:pid");
			$purge_expanded_menu->bindParam(":pid", $this->id, PDO::PARAM_INT);
			$purge_expanded_menu->execute();
			
			$find_expanded_menu = $db->prepare("insert into string_client_settings set setting_key=:setting_key, setting_value=:setting_value, domain_id=:pid, creation_date=UTC_TIMESTAMP()");
			$string_client_settings = $config->string_client_setting;
			
			foreach ($string_client_settings as $string_client_setting) {
				$find_expanded_menu->bindParam(":setting_key", $string_client_setting->setting_key, PDO::PARAM_STR);
				$find_expanded_menu->bindParam(":setting_value", $string_client_setting->setting_value, PDO::PARAM_STR);
				$find_expanded_menu->bindParam(":pid", $this->id, PDO::PARAM_INT);
				$find_expanded_menu->execute();
			}
			
//
//	Set int
//
			
			$purge_int = $db->prepare("delete from int_client_settings where domain_id=:pid");
			$purge_int->bindParam(":pid", $this->id, PDO::PARAM_INT);
			$purge_int->execute();
			
			$find_int = $db->prepare("insert into int_client_settings set setting_key=:setting_key, setting_value=:setting_value, domain_id=:pid, creation_date=UTC_TIMESTAMP()");
			$int_client_settings = $config->int_client_setting;
			
			foreach ($int_client_settings as $int_client_setting) {
				$find_int->bindParam(":setting_key", $int_client_setting->setting_key, PDO::PARAM_STR);
				$find_int->bindParam(":setting_value", $int_client_setting->setting_value, PDO::PARAM_STR);
				$find_int->bindParam(":pid", $this->id, PDO::PARAM_INT);
				$find_int->execute();
			}

			return true;
		}
		catch(Exception $e) {
			gf_log($e); 
			return false; 
		}

	}
	
	public function authorize_domain($domain) {
		try {
			$db = core_db::instance()->get();

			$purge = $db->prepare("delete from domain_security where alloweddomain=:domain and domain=:id");
			$purge->bindParam(":id", $this->id, PDO::PARAM_INT);
			$purge->bindParam(":domain", $domain, PDO::PARAM_STR);
			$purge->execute();

			$find = $db->prepare("insert into domain_security set alloweddomain=:domain, domain=:id");
			$find->bindParam(":id", $this->id, PDO::PARAM_INT);
			$find->bindParam(":domain", $domain, PDO::PARAM_STR);
			$find->execute();

			gf_log($this->id);
			return true;

		}
		catch(Exception $e) {
			gf_log($e); 
			return false; 
		}
	}

	public function deauthorize_domain($domain) {
		try {
			$db = core_db::instance()->get();

			$purge = $db->prepare("delete from domain_security where alloweddomain=:domain and domain=:id");
			$purge->bindParam(":id", $this->id, PDO::PARAM_INT);
			$purge->bindParam(":domain", $domain, PDO::PARAM_STR);
			$purge->execute();

			return true;

		}
		catch(Exception $e) {
			gf_log($e); 
			return false; 
		}
	}

	public function list_authorized_domains() {
		try {
			$db = core_db::instance()->get();

			$find = $db->prepare("select id, alloweddomain from domain_security where domain=:id");
			$find->bindParam(":id", $this->id, PDO::PARAM_INT);
			$find->execute();

			$access_list = array();

			while ($result = $find->fetch(PDO::FETCH_OBJ)) {
				$account = new stdClass();
				$account->domain = $result->alloweddomain;
				$account->id = $result->id;
				array_push($access_list, $account);
			}

			return $access_list;


			return true;

		}
		catch(Exception $e) {
			gf_log($e); 
			return false; 
		}
	}

	public function delete() {
		try {
			$db = core_db::instance()->get();

			$purge = $db->prepare("delete from bool_client_settings where domain_id=:pid");
			$purge->bindParam(":pid", $this->id, PDO::PARAM_INT);
			$purge->execute();

			$purge = $db->prepare("delete from domain_access where domain_id=:pid");
			$purge->bindParam(":pid", $this->id, PDO::PARAM_INT);
			$purge->execute();

			$purge = $db->prepare("delete from domains where id=:pid");
			$purge->bindParam(":pid", $this->id, PDO::PARAM_INT);   
			$purge->execute(); 

			return true;
		}
		catch(Exception $e) {
			gf_log($e); 
			return false; 
		}



	}

}
