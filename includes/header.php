<?php 

include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");

//session_destroy(); MANUAL LOGOUT

if(isset($_SESSION['userLoggedIn'])) {

	$userLoggedIn = $_SESSION['userLoggedIn'];
	echo "<script>userLoggedIn = '$userLoggedIn';</script>";
}
else {

	header("Location: register.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Dotify</title>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>
</head>
<body>

	<!-- 
	Container for all the components of the index page,
	which includes the player bar, the navigation section,
	and the album table.
	-->
	<div id="mainContainer">

		<!-- 
		The top container contains the navigation bar as well as the main table
		that displays the albums.
		-->
		<div id="topContainer">
			
			<?php include("includes/navBarContainer.php") ?>

			<div id="mainSectionContainer">
				
				<div id="mainContent">