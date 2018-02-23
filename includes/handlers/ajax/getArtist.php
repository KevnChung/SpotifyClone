<?php 

include("../../config.php");

if(isset($_POST['artistId'])) {

	$artistId = $_POST['artistId'];

	$artistQuery = mysqli_query($con, "SELECT * FROM artists WHERE id='$artistId'");
	$result = mysqli_fetch_array($artistQuery);
	$jsonResult = json_encode($result);

	echo $jsonResult; 
}

?>