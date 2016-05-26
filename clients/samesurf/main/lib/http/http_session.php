<?php

class http_session {

	protected $id;
	protected $cookieid;
	protected $data;
	protected $is_authorised;
	protected $is_verified;
	protected $session_duration;
	public $account_metadata;

	public function __construct() {
		$this->id = null;
		$this->cookieid = null;
		$this->account = null;
		$this->accountid = null;
		$this->data = new stdClass();
		$this->is_authorised = false;
		$this->session_duration = 6000;
		$this->account_metadata = null;
	}

	public function process($request) {

		$raw_cookieid = null;
		if (isset($_COOKIE["ssid"])) {
			$raw_cookieid = $_COOKIE["ssid"];
		}

		$this->create_or_fetch($raw_cookieid);

		setcookie("ssid", $this->cookieid, time() + $this->session_duration, "/");
		$request->session = $this;

	}

	public function delete() {
		try {
			$db = core_db::instance()->get(); 
			$stmt = $db->prepare("delete from session where id=:id");
			$stmt->bindParam(":id", $this->id, PDO::PARAM_STR);
			$stmt->execute();			
		}
		catch(Exception $e) {
		}
	}	

	protected function get_account() {
		if (!$this->is_authorised) {
			return false;
		}
		else {
			if (!isset($this->account)) {
				$this->account = model_account::get_by_id($this->accountid);
			}
			return $this->account;
		}
	}

	public function grant_auth($account) {

		gf_log("tring to grant auth for...");
		gf_log($account);

		$this->accountid = $account->id();
		$this->account = $account;
		$this->is_authorised = true;
  		$this->account_metadata = model_accountmetadata::get($this->accountid);
   		setcookie("names", $this->account_metadata->first_name . " " . $this->account_metadata->last_name, time() + $this->session_duration, "/");

		if (!isset($this->data->auth)) {
			$this->data->auth = new stdClass();
		}

		$this->data->auth->accountid = $this->accountid;
		$this->save();	
	}

	public function has_auth() {
		return $this->is_authorised;
	}

	public function has_verified() {
		return $this->get_account()->validate_confirmed();
	}
	
	public function accountid() {
		return $this->accountid;
	}

	public function get_data() {
		return $this->data;
	}

	public function set_data($key, $value) {
		if (!isset($this->data->user)) {
			$this->data->user = stdClass();
		} 
		$this->data->user->$key  = $value;
		$this->save();
	}
	
	public function set_details($first_name, $last_name) {
		setcookie("names", $first_name . " " . $last_name, time() + $this->session_duration, "/");
	}

	protected function save() {

		try {

			$db = core_db::instance()->get(); 

			$stmt = $db->prepare("update session set data=:data where id=:id");
			$stmt->bindParam(":data", json_encode($this->data), PDO::PARAM_STR);
			$stmt->bindParam(":id", $this->id, PDO::PARAM_STR);
			$stmt->execute();			

		}
		catch(Exception $e) {
			gf_log($e);
		}
	}

	protected function create_or_fetch($raw_ssid) {

		try {

			$this->cookieid = null;
			$this->id = null;
			$db = core_db::instance()->get(); 

			$fetch = $db->prepare("select * from session where cookieid=:cookieid and creation_date > DATE_ADD(NOW(), INTERVAL -$this->session_duration SECOND)");
			$fetch->bindParam(":cookieid", $raw_ssid, PDO::PARAM_STR);
			$fetch->execute();			

			$result = $fetch->fetch(PDO::FETCH_OBJ);

			if ($result) {
				
				$this->id = $result->id;
				$this->cookieid = $raw_ssid;
				$this->data = json_decode($result->data);
				
				
				if (isset($this->data->auth) && $this->data->auth) {
					$this->accountid = $this->data->auth->accountid;
					$this->is_authorised = true;
 					$this->account_metadata = model_accountmetadata::get($this->accountid);
				}

				$update = $db->prepare("update session set creation_date=NOW() where id=:id");
				$update->bindParam(":id", $this->id);
				$update->execute();
			}
			else {
				$ssid = bin2hex(openssl_random_pseudo_bytes(15));
			    $insert = $db->prepare("insert into session set cookieid=:cookieid, creation_date=NOW()");	
				$insert->bindParam(":cookieid", $ssid, PDO::PARAM_STR);
				$insert->execute();
				$this->id = $db->lastInsertId();
				$this->cookieid = $ssid;
			}
		}
		catch(Exception $e) {
			gf_log($e);
		}
	}

}
