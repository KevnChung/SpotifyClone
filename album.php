<?php include("includes/includedFiles.php"); 

if(isset($_GET['id'])) {

	$albumId = $_GET['id'];
}
else {

	header("Location: index.php");
}

$album = new Album($con, $albumId);
$artist = $album->getArtist();

?>

<div class="entityInfo">

	<div class="leftSection">
		<img src="<?php echo $album->getArtworkPath(); ?>">
	</div>

	<div class="rightSection">
		<h1><?php echo $album->getTitle(); ?></h1>
		<p><?php echo $artist->getName(); ?></p>
		<p>
			<?php 
			echo $album->getNumSongs();

			if($album->getNumSongs() == 1)
				echo " song";
			else 
				echo " songs";
			?>

		</p>
	</div>
	
</div>

<div class="tracklistContainer">
	<ul class="tracklist">
		
		<?php  
			$songIdArray = $album->getSongIdArray();

			$ctr = 1;
			foreach($songIdArray as $songId) {

				$currentSong = new Song($con, $songId);
				$songArtist = $currentSong->getArtist();

				echo "<li class='tracklistItem'>
						<div class='trackCount'>
							<img class='trackPlay' src='assets/images/icons/play-white.png' 
								onclick='setTrack(\"" . $currentSong->getId() . "\", tempPlaylist, true)'>
							<span class='trackNum'>$ctr.</span>
						</div>

						<div class='trackInfo'>
							<span class='trackName'>" . $currentSong->getTitle() . "</span>
							<span class='trackArtist'>" . $songArtist->getName() . "</span>
						</div>

						<div class='trackOptions'>
							<img class='optionsButton' src='assets/images/icons/more.png'>
						</div>

						<div class='trackDuration'>
							<span class='duration'>" . $currentSong->getDuration() . "</span>
						</div>
					</li>";


				$ctr++;
			}
		?>

		<script>
			
			var tempSongIdArray = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIdArray);

		</script>

	</ul>
</div>