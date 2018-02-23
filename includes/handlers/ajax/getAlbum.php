<?php 

include("../../config.php");

if(isset($_POST['albumId'])) {

	$albumId = $_POST['albumId'];

	$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE id='$albumId'");
	$result = mysqli_fetch_array($albumQuery);
	$jsonResult = json_encode($result);

	echo $jsonResult; 
}

?>