<?php include("includes/includedFiles.php"); ?>
			
<h1 class="pageHeaderLarge">Albums You Might Like</h1>	

<div class="albumGridContainer">
	
	<?php 
		$albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY rand() LIMIT 10");

		while($row = mysqli_fetch_array($albumQuery)) {

			echo "<div class='gridItem'>

					<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>

						<img src='" . $row['artworkPath'] . "'>

						<div class='gridInfo'>"
							. $row['title'] .
						"</div>
					</span>
				</div>";
		}
	?>

</div>