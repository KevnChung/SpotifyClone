var currentPlaylist = [];
var shuffledPlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseClicked = false;
var currentSongIndex = 0;
var repeatCurrentSong = false;
var shuffle = false;
var userLoggedIn;

function openPage(url) {

	if(url.indexOf("?") == -1)
		url += "?";
	
	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0);
	history.pushState(null, null, url);
}

// Formats the passed in time parameter into the format minutes:seconds
function formatTime(time) {

	var formatted = Math.round(time);
	var minutes = Math.floor(formatted / 60);
	var seconds = formatted - (minutes * 60);

	var padZero = "";

	if(seconds < 10) {

		padZero = "0";
	}

	return minutes + ":" + padZero + seconds;
}

function updateProgressBar(audio) {

	$(".songTime.current").text(formatTime(audio.currentTime));
	$(".songTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	var progressPercent = audio.currentTime / audio.duration * 100;

	$(".playbackBar .progress").css("width", progressPercent + "%");
}

function updateVolumeBar(audio) {

	var volumePercent = audio.volume * 100;

	$(".volumeBar .progress").css("width", volumePercent + "%");	
}

// Creates a new Audio object, which represents songs to be played by the application
function Audio() {

	//Creates a new audio element 
	this.audio = document.createElement('audio');
	this.currentlyPlaying;
	var self = this;

	this.audio.addEventListener("ended", function() {

		nextTrack();
	});

	// Sets the progress bar's current and remaining time once the audio loads in
	this.audio.addEventListener("canplay", function() {

		$(".songTime.current").text(formatTime(this.currentTime));
		$(".songTime.remaining").text(formatTime(this.duration));
	});

	// Updates the progress bar whenever the time of the song changes
	this.audio.addEventListener("timeupdate", function() {

		if(this.duration) {

			updateProgressBar(this);
		}
	});

	// Updates the plays count of the song when the song is over
	this.audio.addEventListener("ended", function() {

		$.post("includes/handlers/ajax/updatePlays.php", {songId: self.currentlyPlaying.id});
	});

	// Updates the volume bar whenever the audio volume is changed
	this.audio.addEventListener("volumechange", function() {

		updateVolumeBar(this);
	})

	//Sets the current audio track based on the src passed in, which should be a path to an audio file
	this.setTrack = function(track) {

		this.currentlyPlaying = track;
		this.audio.src = track.path;
	}

	//Plays the song
	this.play = function() {

		this.audio.play();
	}

	//Pauses the song
	this.pause = function() {

		this.audio.pause();
	}

	this.setTime = function(newTime) {

		this.audio.currentTime = newTime;
	}
}