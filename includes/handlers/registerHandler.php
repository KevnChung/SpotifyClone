<?php

// Cleans up strings by removing html tags, deleting spaces, and uppercasing the first letter
function sanitizeString($sanitizedInput) {

	$sanitizedInput = strip_tags($sanitizedInput);
	$sanitizedInput = str_replace(" ", "", $sanitizedInput);
	$sanitizedInput = ucfirst(strtolower($sanitizedInput));
	return $sanitizedInput;
}

// Deletes html tags and spaces
function sanitizeUsername($sanitizedInput) {

	$sanitizedInput = strip_tags($sanitizedInput);
	$sanitizedInput = str_replace(" ", "", $sanitizedInput);
	return $sanitizedInput;
}

// Only deletes html tags
function sanitizePassword($sanitizedInput) {

	$sanitizedInput = strip_tags($sanitizedInput);
	return $sanitizedInput;
}

//Occurs when register button is pressed
if (isset($_POST['registerButton'])) {

	$username = sanitizeUsername($_POST['registerUsername']);

	$firstName = sanitizeString($_POST['firstName']);
	$lastName = sanitizeString($_POST['lastName']);
	$email = sanitizeString($_POST['email']);
	$confirmEmail = sanitizeString($_POST['confirmEmail']);

	$password = sanitizePassword($_POST['registerPassword']);
	$confirmPassword = sanitizePassword($_POST['confirmPassword']);

	$registerSuccess = $account->register($username, $firstName, $lastName, $email, $confirmEmail, $password, $confirmPassword);

	if($registerSuccess) {

		$_SESSION['userLoggedIn'] = $username;
		header("Location: index.php");
	}
}

?>