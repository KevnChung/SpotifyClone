<?php 

$randPlaylistQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY rand() LIMIT 10");

$songsArray = array();

while($row = mysqli_fetch_array($randPlaylistQuery)) {

	array_push($songsArray, $row['id']);
}

$jsonSongsArray = json_encode($songsArray);

?>

<script>
	
	//Loads in an array of 10 random songs only AFTER all the elements in the page have loaded in
	$(document).ready(function() {

		var newPlaylist = <?php echo $jsonSongsArray; ?>;
		audioElement = new Audio();
		setTrack(newPlaylist[0], newPlaylist, false);
		updateVolumeBar(audioElement.audio);

		$("#playerBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {

			e.preventDefault();
		})

		// If the mouse is clicked on the progress bar, sets the mouseClicked var to true
		$(".playbackBar .progressBar").mousedown(function() {

			mouseClicked = true;
		});

		// Moves the playback bar and the song in accordance with the mouse being moved
		$(".playbackBar .progressBar").mousemove(function(e) {

			if(mouseClicked) {

				changeSongTime(e, this);
			}
		});

		// Leaves the song at the point where the user lets go of the mouse on the progress bar
		$(".playbackBar .progressBar").mouseup(function(e) {

			changeSongTime(e, this);
		});

		$(".volumeBar .progressBar").mousedown(function() {

			mouseClicked = true;
		});

		$(".volumeBar .progressBar").mousemove(function(e) {

			if(mouseClicked) {

				changeVolume(e, this);
			}
		});

		$(".volumeBar .progressBar").mouseup(function(e) {

			changeVolume(e, this);
		});

		$(document).mouseup(function() {

			mouseClicked = false;
		});
	});

	// Changes the current time of the song being played based on the position of the mouse
	function changeSongTime(mouse, progressBar) {

		var percent = mouse.offsetX / $(progressBar).width();
		var seconds = audioElement.audio.duration * percent
		audioElement.setTime(seconds);
	}

	function changeVolume(mouse, volumeBar) {

		var percent = mouse.offsetX / $(volumeBar).width();

		if(percent >= 0 && percent <= 1) 
			audioElement.audio.volume = percent;
	}

	function prevTrack() {

		if(audioElement.audio.currentTime >= 3 || currentSongIndex == 0 || repeatCurrentSong)
			audioElement.setTime(0);
		else {

			currentSongIndex--;
			setTrack(currentPlaylist[currentSongIndex], currentPlaylist, true);
		}

	}

	function nextTrack() {

		if(repeatCurrentSong) {

			audioElement.setTime(0);
			playTrack();
			return;
		}
		
		if(currentSongIndex == currentPlaylist.length - 1)
			currentSongIndex = 0;
		else 
			currentSongIndex++;
		

		var nextSong = shuffle ? shuffledPlaylist[currentSongIndex]: currentPlaylist[currentSongIndex];
		setTrack(nextSong, currentPlaylist, true);
	}

	function toggleRepeat() {

		repeatCurrentSong = !repeatCurrentSong;
		var repeatImage = "repeat.png";

		if(repeatCurrentSong) 
			repeatImage = "repeat-active.png";

		$(".controlButton.repeat img").attr("src", "assets/images/icons/" + repeatImage);
	}

	function toggleMute() {

		audioElement.audio.muted = !audioElement.audio.muted;
		var volumeImage = "volume.png";

		if(audioElement.audio.muted) 
			volumeImage = "volume-mute.png";

		$(".controlButton.volume img").attr("src", "assets/images/icons/" + volumeImage);
	}

	function toggleShuffle() {

		shuffle = !shuffle;
		var shuffleImage = "shuffle.png";

		if(shuffle) 
			shuffleImage = "shuffle-active.png";

		$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + shuffleImage);

		if(shuffle) {

			shuffleArray(shuffledPlaylist);
			currentSongIndex = shuffledPlaylist.indexOf(audioElement.currentlyPlaying.id);
		}
		else {

			currentSongIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
		}
	}

	function shuffleArray(arrayToBeShuffled) {

		var j, x, i;

	    for (i = arrayToBeShuffled.length - 1; i > 0; i--) {

	        j = Math.floor(Math.random() * (i + 1));
	        x = arrayToBeShuffled[i];
	        arrayToBeShuffled[i] = arrayToBeShuffled[j];
	        arrayToBeShuffled[j] = x;
	    }
	}

	//Sets the currently playing track
	function setTrack(trackId, newPlaylist, play) {

		if(newPlaylist != currentPlaylist) {

			currentPlaylist = newPlaylist;
			shuffledPlaylist = currentPlaylist.slice();
			shuffleArray(shuffledPlaylist);
		}

		/* Sets the current song to be either the first song in our randomized playlist
		 * or our non-random playlist, depending if the user has clicked the shuffle button. */
		if(shuffle)
			currentSongIndex = shuffledPlaylist.indexOf(trackId);
		else
			currentSongIndex = currentPlaylist.indexOf(trackId);

		// Using an ajax call, gets the data of the song with ID trackId
		$.post("includes/handlers/ajax/getSong.php", {songId: trackId}, function(songData) {

			var track = JSON.parse(songData);

			$(".trackName span").text(track.title); //Updates the song label in the player

			/* Gets the artist of the song currently being played and
			 * updates the corresponding label in the player. */
			$.post("includes/handlers/ajax/getArtist.php", {artistId: track.artist}, function(artistData) {

				var artist = JSON.parse(artistData);

				$(".artistName span").text(artist.name);
			});

			/* Gets the album of the song currently being played and
			 * updates the album art in the player. */
			$.post("includes/handlers/ajax/getAlbum.php", {albumId: track.album}, function(albumData) {

				var album = JSON.parse(albumData);

				$(".albumLink img").attr("src", album.artworkPath);
			});

			audioElement.setTrack(track); //Sets the audio element to point to the current song

			if(play)
				playTrack();
		});
	}

	// Plays the current song and hides the play button while showing the pause button
	function playTrack() {

		$(".controlButton.play").hide();
		$(".controlButton.pause").show();
		audioElement.play();
	}

	// Pauses the current song and hides the pause button while showing the play button
	function pauseTrack() {

		$(".controlButton.pause").hide();
		$(".controlButton.play").show();
		audioElement.pause();
	}

</script>

<!-- 
This container is always at the bottom of the page, it contains the player bar, 
which is used to represent the audio and info of the currently playing song.
-->
<div id="playerBarContainer">

	<!-- Main div of the player bar, necessary because the player bar is split up into 3 sections -->
	<div id="playerBar">

		<!-- The left portion of the player bar, which contains the track info (album art, artist, and song title) -->
		<div id="playerLeft">
			<div class="content">

				<span class="albumLink">
					<img src="" class="albumArt">
				</span>

				<div class="trackInfo">
					<span class="trackName">
						<span></span>
					</span>

					<span class="artistName">
						<span></span>
					</span>
				</div>

			</div>
		</div>

		<!-- 
		Middle section of the player bar, contains all media controls 
		and the progress bar of the currently playing track. 
		-->
		<div id="playerMiddle">
			
			<div class="content playerControls">
				
				<!-- Houses all the buttons for the player (pause, forward, back, etc.) -->
				<div class="buttons">
					
					<button class="controlButton shuffle" title="Shuffle" onclick="toggleShuffle()"> 
						<img src="assets/images/icons/shuffle.png" alt="Shuffle">
					</button>

					<button class="controlButton previous" title="Previous" onclick="prevTrack()">
						<img src="assets/images/icons/previous.png" alt="Previous">
					</button>

					<button class="controlButton play" title="Play" onclick="playTrack()">
						<img src="assets/images/icons/play.png" alt="Play">
					</button>

					<button class="controlButton pause" title="Pause" style="display: none" onclick="pauseTrack()">
						<img src="assets/images/icons/pause.png" alt="Pause">
					</button>

					<button class="controlButton next" title="Next" onclick="nextTrack()">
						<img src="assets/images/icons/next.png" alt="Next">
					</button>

					<button class="controlButton repeat" title="Repeat" onclick="toggleRepeat()">
						<img src="assets/images/icons/repeat.png" alt="Repeat">
					</button>

				</div>

				<!-- The actual bar that represents the playback of the currently playing song. -->
				<div class="playbackBar">
					
					<span class="songTime current">0.00</span>

					<!-- 
					Two bars inside of each other represent the amount of the 
					song that has elapsed and is currently remaining. 
					-->
					<div class="progressBar" style="margin-top: 3px">
						<div class="progressBg">
							<div class="progress"></div>
						</div>
					</div>

					<span class="songTime remaining">0.00</span>

				</div>

			</div>

		</div>
		
		<!-- The right section of the player bar, which simply contains the controls for the volume. -->
		<div id="playerRight">
			
			<!-- 
			The volume bar also has a progress bar, which is used instead to represent the level 
			of volume that the user can choose. 
			-->
			<div class="volumeBar">
				<button class="controlButton volume" title="Volume" onclick="toggleMute()">
					<img src="assets/images/icons/volume.png" alt="Volume">
				</button>

				<div class="progressBar">
					<div class="progressBg">
						<div class="progress"></div>
					</div>
				</div>
			</div>
			
		</div>

	</div>

</div>