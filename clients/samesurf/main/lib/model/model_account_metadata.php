<?php

class model_accountmetadata_hummmmmm {

		private $first_name;
		private $last_name;

		private function __construct() {
			$first_name = null;
			$last_name = null;
		}

		public function set_metadata($metadata, $accountid) {
			try{
				gf_log("start set");
				$db = core_db::instance()->get();
				$insert = $db->prepare("insert into account_details set account_id=:account_id, first_name=:first_name, last_name=:last_name, creation_date=UTC_TIMESTAMP()");	

				$insert->bindParam(":account_id", $accountid, PDO::PARAM_INT);
				$insert->bindParam(":first_name", $metadata->first_name, PDO::PARAM_STR);
				$insert->bindParam(":last_name", $metadata->last_name, PDO::PARAM_STR);
				gf_log("start execute");
				if ($insert->execute()) {
					return true;
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
			catch (Exception $e){
				gl_log($e;)
			}
				
		}

		public static function get($accountid) {
	
			try{
				gf_log("start get");
				$db = core_db::instance()->get();
				$insert = $db->prepare("select * from account_details where account_id=:account_id order by creation_date desc limit 1");	
				$insert->bindParam(":account_id", $accountid, PDO::PARAM_INT);
	
				if ($insert->execute()) {
					$result = $find->fetch(PDO::FETCH_OBJ);
	
					$metadata = new model_account_metadata();
					$metadata->first_name = $result->first_name;
					$metadata->last_name = $result->last_name;

					return $metadata;
				}
				else {
					gf_log($insert->errorInfo());
					return false;
				}
				
				}
			catch (Exception $e){
				gl_log($e;)
			}
		}
}
