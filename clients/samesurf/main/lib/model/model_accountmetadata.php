<?php

class model_accountmetadata {

		public $first_name;
		public $last_name;
		public $location;
		public $organization;

		public function set_metadata($metadata, $accountid) {

			$db = core_db::instance()->get();
			$insert = $db->prepare("insert into account_details set account_id=:account_id, first_name=:first_name, last_name=:last_name, location=:location, organization=:organization, creation_date=UTC_TIMESTAMP()");	
	
			$insert->bindParam(":account_id", $accountid, PDO::PARAM_INT);
			$insert->bindParam(":first_name", $metadata->first_name, PDO::PARAM_STR);
			$insert->bindParam(":last_name", $metadata->last_name, PDO::PARAM_STR);
			$insert->bindParam(":location", $metadata->location, PDO::PARAM_STR);
			$insert->bindParam(":organization", $metadata->organization, PDO::PARAM_STR);


			if ($insert->execute()) {
				return true;
			}
			else {
				if ($insert->errorCode() == 23000) {
					throw new exception_mysqlduplicate();
				}
				else {
					gf_log($insert->errorInfo());
					throw new Exception("unknown mysql error");  
				}
			}	
		}

		public static function get($accountid) {
			
			$db = core_db::instance()->get();
			$find = $db->prepare("select * from account_details where account_id=:account_id order by creation_date desc limit 1");
//			$find = $db->prepare("select * from account_details where account_id=:account_id");	
			$find->bindParam(":account_id", $accountid, PDO::PARAM_INT);

			gf_log("LOOKLOOK -> $accountid");

			if ($find->execute()) {
				$result = $find->fetch(PDO::FETCH_OBJ);
				$metadata = new model_accountmetadata();
				if ($result) {
					$metadata->first_name = $result->first_name;
					$metadata->last_name = $result->last_name;
					$metadata->organization = $result->organization;
					$metadata->location = $result->location;
					$metadata->services = $result->services;

				}
				
				return $metadata;
			}
			else {
				gf_log($find->errorCode());
				$insert = $db->prepare("insert into account_details set account_id=:account_id, first_name=:first_name, last_name=:last_name, location=:location, organization=:organization, creation_date=UTC_TIMESTAMP()");	
		
				$insert->bindParam(":account_id", $accountid, PDO::PARAM_INT);
				$insert->bindParam(":first_name", "Not Set - Default", PDO::PARAM_STR);
				$insert->bindParam(":last_name", "Not Set - Default", PDO::PARAM_STR);
				$insert->bindParam(":location", "Not Set - Default", PDO::PARAM_STR);
				$insert->bindParam(":organization", "Not Set - Default", PDO::PARAM_STR);
	
				if ($insert->execute()) {
					$find = $db->prepare("select * from account_details where account_id=:account_id order by creation_date desc limit 1");	
					$find->bindParam(":account_id", $accountid, PDO::PARAM_INT);
		
					gf_log("LOOK again -> $accountid");
		
					if ($find->execute()) {
						$result = $find->fetch(PDO::FETCH_OBJ);
						$metadata = new model_accountmetadata();
						if ($result) {
							$metadata->first_name = $result->first_name;
							$metadata->last_name = $result->last_name;
							$metadata->organization = $result->organization;
							$metadata->location = $result->location;
							$metadata->services = $result->services;

						}
						
						return $metadata;
				}else{
					return false;
					}
				}	
			}
  		}
  		
}
