<?php 

include("../../config.php");

if(isset($_POST['songId'])) {

	$songId = $_POST['songId'];

	$songQuery = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'");
	$result = mysqli_fetch_array($songQuery);
	$jsonResult = json_encode($result);

	echo $jsonResult; 
}

?>