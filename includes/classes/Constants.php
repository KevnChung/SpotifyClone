<?php 

/* Class that contains all the error messages in the site. Allows for the error messages to be changed
   only once across all the files. */	
class Constants {

	public static $loginFailed = "Login failed. Your username or password was incorrect!";

	public static $usernameTaken = "That username has already been taken!";

	public static $emailNoMatch = "Your emails must match!";
	public static $emailInvalid = "Your email is invalid!";
	public static $emailTaken = "That email is already being used!";

	public static $passwordNoMatch = "Your passwords must match!";
	public static $passwordTooShort = "Your password must be at least 8 characters long!";
	public static $passwordNoNumber = "Your password must contain at least one number!";
	public static $passwordNoCapital = "Your password must contain at least one capital letter!";
	public static $passwordNoLower = "Your password must contain at least one lowercase letter!";
}

?>