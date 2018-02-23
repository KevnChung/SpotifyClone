<?php

	class Account {

		private $con;
		private $errors;

		public function __construct($con) {

			$this->con = $con;
			$this->errors = array();
		}

		public function login($un, $pw) {

			$pw = md5($pw);

			$query = mysqli_query($this->con, "SELECT * from users WHERE username='$un' AND password='$pw'");

			if(mysqli_num_rows($query) == 1) {

				return true;
			}
			else {

				array_push($this->errors, Constants::$loginFailed);
				return false;
			}
		}

		public function register($un, $fn, $ln, $em, $confirmEm, $pw, $confirmPw) {

			$this->validateUsername($un);
			$this->validateEmails($em, $confirmEm);
			$this->validatePasswords($pw, $confirmPw);

			// Checks to see if there are any errors that occured during validation.
			if(empty($this->errors)) {

				// Insert into database
				return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
			}
			else {

				return false;
			}
		}

		public function getError($err) {

			if(!in_array($err, $this->errors)) {

				$err = "";
			}

			return "<span class='errorMessage'>$err</span>";
		}

		private function insertUserDetails($un, $fn, $ln, $em, $pw) {

			$encryptedPw = md5($pw);
			$profilePic = "assets/images/profile-pictures/placeholder.jpg";
			$date = date("Y-m-d");

			$result = mysqli_query($this->con, "INSERT INTO users VALUES ('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");

			return $result;
		}

		//Checks to see fi the username the user typed in is valid 
		private function validateUsername($un) {

			// Checks to see if the desired username is already in the db, that is if it has already been taken
			$checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
			if(mysqli_num_rows($checkUsernameQuery) != 0) {

				array_push($this->errors, Constants::$usernameTaken);
			}
		}

		// Checks to see if the email the user typed in is valid
		private function validateEmails($em, $confirmEm) {

			/* Checks if the username put in the same email in both the first and second
			// email boxes */
			if($em != $confirmEm) {

				array_push($this->errors, Constants::$emailNoMatch);
				return;
			}	

			// Checks to see if correct email format is used, with an @ symbol plus a ".com"
			if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {

				array_push($this->errors, Constants::$emailInvalid);
				return;
			}

			// Checks to see if the email is already in the db, that is if it has already been taken
			$checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
			if(mysqli_num_rows($checkEmailQuery) != 0) {

				array_push($this->errors, Constants::$emailTaken);
			}
		}

		// Checks to see if the password the user entered is valid
		private function validatePasswords($pw, $confirmPw) {

			//Checks to see if the password the user entered is the same in both password boxes
			if($pw != $confirmPw) {

				array_push($this->errors, Constants::$passwordNoMatch);
				return;
			}

			// Ensures that the password must be at least 8 characters long
			if(strlen($pw) < 8) {

				array_push($this->errors, Constants::$passwordTooShort);
				return;
			}

			/* Following three if-statements ensure that the password has at least one number, one 
			   capital letter, and one lowercase letter. */

			if(!preg_match("#[0-9]+#", $pw)) {

				array_push($this->errors, Constants::$passwordNoNumber);
				return;
			}

			if(!preg_match("#[A-Z]+#", $pw)) {

				array_push($this->errors, Constants::$passwordNoCapital);
				return;
			}

			if(!preg_match("#[a-z]+#", $pw)) {

				array_push($this->errors, Constants::$passwordNoLower);
				return;
			}
		}
	}

?>