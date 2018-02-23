<!-- 
Navigation bar container; contains all the links for various pages within the web app, 
which includes the search, browse, personal library, and profile pages.
-->
<div id="navBarContainer">
	<nav class="navBar">
		
		<!-- Anchor tag for the logo at the top of the nav bar, redirects to the index page. -->
		<span role="link" tabindex="0" onclick="openPage('index.php')" class="mainLogo">
			<img src="assets/images/icons/logo.png">
		</span>

		<!-- Specialized group for the search link. -->
		<div class="group">
			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('search.php')" class="navItemLink">
					Search
					<img src="assets/images/icons/search.png" class="icon" alt="search">
				</span>
			</div>
		</div>

		<!-- Contains all the other links for the browse, your music, and profile pages. -->
		<div class="group">

			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Browse</span>
			</div>

			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('music.php')" class="navItemLink">Your Music</span>
			</div>

			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('profile.php')" class="navItemLink">Your Profile</span>
			</div>
		</div>
	</nav>
</div>