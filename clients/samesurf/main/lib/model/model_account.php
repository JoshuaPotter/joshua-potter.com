<?php 

// first name.
// last name.
// domain.
// sharing or support or both.

define("SALT", "Saltier and saltier and saltier");

class model_account {

	private $id;
	private $email;
	private $password;
	private $confirmed;
	private $tut_complete;

    private function __construct() {
		$id = null;
		$email = null;	
		$password = null;
		$confirmed = false;
		$tut_complete = false;
	}

	public static function create($email, $password) {

		$saltypassword = sha1(SALT . $password);
	
		$db = core_db::instance()->get();
	    $insert = $db->prepare("insert into accounts set email=:email, password=:password, confirmed=0, tut_complete=0, creation_date=UTC_TIMESTAMP()");	
		$insert->bindParam(":email", $email, PDO::PARAM_STR);
		$insert->bindParam(":password", $saltypassword, PDO::PARAM_STR);

		if ($insert->execute()) {
			$account = new model_account();
			$account->id = $db->lastInsertId();
			$account->email = $email;
			$account->password = $saltypassword;
			$account->confirmed = false;
			$account->tut_complete = false;
			return $account;
		}
		else {
			if ($insert->errorCode() == 23000) {
				throw new exception_mysqlduplicate();
			}
			else {
				throw new Exception("unknown mysql error");  
			}
		}	
	}

	public static function get_by_email($email) {
	
		$db = core_db::instance()->get();
			
	    $find = $db->prepare("select * from accounts where email=:email");	
		$find->bindParam(":email", $email, PDO::PARAM_STR);
		$find->execute();
		$result = $find->fetch(PDO::FETCH_OBJ);

		if ($result) {
			$account = new model_account();
			$account->id = $result->id;
			$account->email = $result->email;
			$account->password = $result->password;
			if ($result->confirmed == 1) {
				$account->confirmed = true;
			}
			if ($result->tut_complete == 1) {
				$account->tut_complete = true;
			}
			return $account;
		}	
		else {
			return false;
		}

	}


	public static function get_by_id($id) {
		$db = core_db::instance()->get();
			
	    $find = $db->prepare("select * from accounts where id=:id");	
		$find->bindParam(":id", $id, PDO::PARAM_STR);
		$find->execute();
		$result = $find->fetch(PDO::FETCH_OBJ);

		if ($result) {
			$account = new model_account();
			$account->id = $result->id;
			$account->email = $result->email;
			$account->password = $result->password;
			if ($result->confirmed == 1) {
				$account->confirmed = true;
			}
			if ($result->tut_complete == 1) {
				$account->tut_complete = true;
			}
			return $account;
		}	
		else {
			return false;
		}
	}

	public function id() {
		return $this->id;
	}

	public function email() {
		return $this->email;
	}

	public function validate_confirmed() {
		return $this->confirmed;
	}
	
	public function tut_complete() {
		return $this->tut_complete;
	}
	
	public function tut_complete_complete() {
		$db = core_db::instance()->get();
		$update = $db->prepare("update accounts set tut_complete=1 where id=:id");
		$update->bindParam(":id", $this->id);
		$update->execute();
		
		$this->tut_complete = true;
	}
	
	public function validate_password($password) {
		$saltytest = sha1(SALT . $password);
		if ($saltytest == $this->password) {
			return true;
		}
		return false;
	}
	public function reset_password($password) {
		try {
			$salty = sha1(SALT . $password);
			$db = core_db::instance()->get();
			$update = $db->prepare("update accounts set password=:password where id=:id");
			$update->bindParam(":id", $this->id);
			$update->bindParam(":password", $salty);
			$update->execute();

		    $insert = $db->prepare("delete from account_reset_tokens where account_id=:id");	
			$insert->bindParam(":id", $this->id, PDO::PARAM_STR);
		}
		catch(Exception $e) {

		}
	}

	/*
	 * Verify the new account belongs to an actual person account.
    */
	public function generate_validate_token() {
	
		$db = core_db::instance()->get();

		$token = bin2hex(openssl_random_pseudo_bytes(20));
		
	    $insert = $db->prepare("insert into account_validate_tokens set account_id=:id, token=:token, creation_date=UTC_TIMESTAMP()");	
		$insert->bindParam(":id", $this->id, PDO::PARAM_STR);
		$insert->bindParam(":token", $token, PDO::PARAM_STR);

		if ($insert->execute()) {
			return $token;
		}
		else {
			if ($insert->errorCode() == 23000) {
				throw new exception_mysqlduplicate();
			}
			else {
				throw new Exception("unknown mysql error");  
			}
		}	
	}

	public static function validate_validate_token($token) {

		$db = core_db::instance()->get();
			
	    $insert = $db->prepare("select * from account_validate_tokens where token=:token");	
		$insert->bindParam(":token", $token, PDO::PARAM_STR);
		$insert->execute();
		$result = $insert->fetch(PDO::FETCH_OBJ);
	
		if ($result) {

			$update = $db->prepare("update accounts set confirmed=1 where id=:id");
			$update->bindParam(":id", $result->account_id);
			$update->execute();

			try {
				$delete = $db->prepare("delete from account_validate_tokens where account_id=:id");	
				$delete->bindParam(":id", $result->account_id, PDO::PARAM_STR);
				$delete->execute();
			}
			catch (Exception $e) {
				// keep it clean but don't worry about it.
			}
			$account = self::get_by_id($result->account_id);
			return $account;
		}	
		return false;	
	}

	public function generate_password_reset_token() {

		$db = core_db::instance()->get();
		$token = bin2hex(openssl_random_pseudo_bytes(20));

	    $insert = $db->prepare("insert into account_reset_tokens set account_id=:id, token=:token, creation_date=UTC_TIMESTAMP()");	
		$insert->bindParam(":id", $this->id, PDO::PARAM_STR);
		$insert->bindParam(":token", $token, PDO::PARAM_STR);

		if ($insert->execute()) {
			return $token;
		}
		else {
			if ($insert->errorCode() == 23000) {
				throw new exception_mysqlduplicate();
			}
			else {
				throw new Exception("unknown mysql error");  
			}
		}
	}

	public static function validate_password_reset_token($token) {
	
		$db = core_db::instance()->get();
		
	    $insert = $db->prepare("select * from account_reset_tokens where token=:token and creation_date > DATE_ADD(NOW(), INTERVAL - 60 * 60 * 2 SECOND)");	
		$insert->bindParam(":token", $token, PDO::PARAM_STR);
		$insert->execute();
		$result = $insert->fetch(PDO::FETCH_OBJ);
	
		if ($result) {
			return model_account::get_by_id($result->account_id);
		}	
		return false;
	}

}
