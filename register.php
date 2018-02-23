<?php

	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include("includes/handlers/registerHandler.php");
	include("includes/handlers/loginHandler.php");

	function getInputText($name) {

		if(isset($_POST[$name])) {

			echo $_POST[$name];
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Welcome to Dotify!</title>

	<link rel="stylesheet" type="text/css" href="assets/css/register.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>

	<?php 

		if(isset($_POST['registerButton'])) {

			echo '<script>
		
					$(document).ready(function() {

						$("#loginForm").hide();
						$("#registerForm").show();
					});
				</script>';
		}
		else {

			echo '<script>
		
					$(document).ready(function() {

						$("#loginForm").show();
						$("#registerForm").hide();
					});
				</script>';
		}

	?>

	<script>
		
		$(document).ready(function() {

			$("#loginForm").show();
			$("#registerForm").hide();
		});
	</script>

	<div id="background">

		<div id="loginContainer">

			<div id="inputContainer">
				<!-- The form used to get login and password information from the user. -->
				<form id="loginForm" action="register.php" method="POST">
					<h2>Login to your account</h2>
					<p>
						<?php echo $account->getError(Constants::$loginFailed); ?>
						<input id="loginUsername" type="text" name="loginUsername" placeholder="Username" value="<?php getInputText('loginUsername') ?>" required>
					</p>
					<p>
						<input id="loginPassword" type="password" name="loginPassword" placeholder="Password" required>
					</p>
			
					<button type="submit" name="loginButton">LOG IN</button>

					<div class="hasAccountText">
						<span id="hideLogin">Don't have an account yet? Sign up here!</span>
					</div>

				</form>

				<!-- Form for new users to register a Hotify account -->
				<form id="registerForm" action="register.php" method="POST">
					<h2>Create your free account</h2>
					<p>
						<?php echo $account->getError(Constants::$usernameTaken); ?>
						<input id="registerUsername" type="text" name="registerUsername" placeholder="Username" value="<?php getInputText('registerUsername') ?>" required>
					</p>
					<p>
						<input id="firstName" type="text" name="firstName" placeholder="First name" value="<?php getInputText('firstName') ?>" required>
					</p>
					<p>
						<input id="lastName" type="text" name="lastName" placeholder="Last name" value="<?php getInputText('lastName') ?>" required>
					</p>
					<p>
						<?php
							echo $account->getError(Constants::$emailInvalid); 
							echo $account->getError(Constants::$emailTaken);
						?>
						<input id="email" type="email" name="email" placeholder="Email" value="<?php getInputText('email') ?>" required>
					</p>
					<p>
						<?php echo $account->getError(Constants::$emailNoMatch); ?>
						<input id="confirmEmail" type="email" name="confirmEmail" placeholder="Re-enter email" value="<?php getInputText('confirmEmail') ?>" required>
					</p>

					<p>
						<?php 
							echo $account->getError(Constants::$passwordTooShort);
							echo $account->getError(Constants::$passwordNoNumber);
							echo $account->getError(Constants::$passwordNoCapital);
							echo $account->getError(Constants::$passwordNoLower);
						?>
						<input id="registerPassword" type="password" name="registerPassword"  placeholder="Password" required>
					</p>
					<p>
						<?php echo $account->getError(Constants::$passwordNoMatch); ?>
						<input id="confirmPassword" type="password" name="confirmPassword" placeholder="Re-enter password" required>
					</p>
			
					<button type="submit" name="registerButton">SIGN UP</button>

					<div class="hasAccountText">
						<span id="hideRegister">Already have an account? Log in here!</span>
					</div>

				</form>
			</div>

			<div id="loginText">
				<h1>Listen to great music, right now</h1>	
				<h2>Listen to loads of songs for free</h2>
				<ul>
					<li>Discover amazing new music</li>
					<li>Create playlists of the songs that you love</li>
					<li>Follow all of your favorite artists</li>
				</ul>
			</div>

		</div>
	</div>	
</body>
</html>