<?php 

	class Album {

		private $con;
		private $id;
		private $title;
		private $artistId;
		private $genreId;
		private $artworkPath;

		public function __construct($con, $id) {

			$this->con = $con;
			$this->id = $id;

			$albumQuery = mysqli_query($this->con, "SELECT * FROM albums WHERE id='$this->id'");
			$album = mysqli_fetch_array($albumQuery);

			$this->title = $album['title'];
			$this->artistId = $album['artist'];
			$this->genreId = $album['artist'];
			$this->artworkPath = $album['artworkPath'];
		}

		public function getTitle() {

			return $this->title;
		}

		public function getArtist() {

			return new Artist($this->con, $this->artistId);
		}

		public function getGenre() {

			return $this->genreId;
		}

		public function getArtworkPath() {

			return $this->artworkPath;
		}

		public function getNumSongs() {

			$numSongsQuery = mysqli_query($this->con, "SELECT * FROM songs WHERE album='$this->id'");
			return mysqli_num_rows($numSongsQuery);
		}

		public function getSongIdArray() {

			$songArrayQuery = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id' ORDER BY trackNumber ASC");
			$songArray = array();

			while($row = mysqli_fetch_array($songArrayQuery)) {

				array_push($songArray, $row['id']);
			}

			return $songArray;
		} 
	}

?>