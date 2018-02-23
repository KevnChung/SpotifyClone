<?php 

	class Song {

		private $con;
		private $id;
		private $sqlData;
		private $title;
		private $artistId;
		private $albumId;
		private $genreId;
		private $duration;
		private $audioPath;

		public function __construct($con, $id) {

			$this->con = $con;
			$this->id = $id;

			$songQuery = mysqli_query($this->con, "SELECT * FROM songs WHERE id='$this->id'");
			$this->sqlData = mysqli_fetch_array($songQuery);
			$this->title = $this->sqlData['title'];
			$this->artistId = $this->sqlData['artist'];
			$this->albumId = $this->sqlData['album'];
			$this->genreId = $this->sqlData['genre'];
			$this->duration = $this->sqlData['duration'];
			$this->audioPath = $this->sqlData['path'];
		}

		public function getId() {

			return $this->id;
		}

		public function getTitle() {

			return $this->title;
		}

		public function getArtist() {

			return new Artist($this->con, $this->artistId);
		}

		public function getAlbum() {

			return new Album($this->con, $this->albumId);
		}

		public function getGenre() {

			return $this->genreId;
		}

		public function getDuration() {

			return $this->duration;
		}

		public function getAudioPath() {

			return $this->audioPath;
		}
	}

?>