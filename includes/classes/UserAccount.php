<?php
	class UserAccount {

		private $con;
		private $errorArray;

		public function __construct($con) {
			$this->con = $con;
			$this->errorArray = array();
		}
        

		public function login($em, $pw) {

			$pw = md5($pw);

			
			$Uquery = mysqli_query($this->con, "SELECT * FROM user WHERE emailid='$em' AND password='$pw'");

			if(mysqli_num_rows($Uquery) == 1) {
				return true;
			}

			else {
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}

		public function isErrorPresent($error){
			return in_array($error, $this-> errorArray);
		} 

		public function register($name, $phone, $em,$address,$lat,$lng, $license, $pw, $pw2,$usertype) {
			
			$this->validatePasswords($pw, $pw2);
			$this->validateemail($em);


			if(empty($this->errorArray) == true) {
				//Insert into db
				return $this->insertUserDetails($name, $phone, $em,$address,$lat,$lng, $license, $pw, $pw2,$usertype);
			}
			else {
				return false;
			}

		}

		public function getError($error) {
			if(!in_array($error, $this->errorArray)) {
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}

		private function insertUserDetails($name, $phone, $em,$address,$lat,$lng, $license, $pw, $pw2,$usertype) {
			$encryptedPw = md5($pw);
			$date = date("Y-m-d");
			if(usertype=="2"){
				$license=NULL;
			}
			
			
			$result = mysqli_query($this->con, "INSERT INTO user VALUES ('','$name', '$phone', '$em', '$address','$lat','$lng', '$license', '$encryptedPw','$usertype','$date')");

			return $result;
		}


		private function validatePasswords($pw, $pw2) {
			
			if($pw != $pw2) {
				array_push($this->errorArray, "Your passwords don't match");
				return;
			}

			if(preg_match('/[^A-Za-z0-9]/', $pw)) {
				array_push($this->errorArray, "Your password can only contain numbers and letters");
				return;
			}

			if(strlen($pw) > 30 || strlen($pw) < 5) {
				array_push($this->errorArray, "Your password must be between 5 and 30 characters");
				return;
			}

		}

		
		private function validateemail($em) {
			$checkEmailuserQuery = mysqli_query($this->con, "SELECT emailid FROM user WHERE emailid='$em'");
			$checkEmailretailerQuery = mysqli_query($this->con, "SELECT emailid FROM retailer WHERE emailid='$em'");
			if(mysqli_num_rows($checkEmailuserQuery) != 0 || mysqli_num_rows($checkEmailretailerQuery) != 0) {
				array_push($this->errorArray, Constants::$emailNotUnique);
				return;
			}

			

		}
 
			

		


	}
?>