<?php 
	include("includes/config.php");

// USER
	$userLoggedIn = '';
	if(isset($_SESSION['userLoggedIn'])) {
	    $userLoggedIn = $_SESSION['userLoggedIn'];
	    echo "<script>userLoggedIn = '$userLoggedIn';</script>";
	}

	
	 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Medicine Information</title>
	<!-- Bootstrap CDN -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	
	<!-- Google Font link -->
	<link href="https://fonts.googleapis.com/css?family=Do+Hyeon" rel="stylesheet">
	
	<!-- Font Awesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	
	<!-- Link Of Search Page CSS file -->
	<link rel="stylesheet" type="text/css" href="includes/assets/css/medicine.css">
	<link rel="stylesheet" type="text/css" href="includes/assets/css/homepage.css">
</head>
<body>
	<!-- Navbar -->
	<?php include("includes/navbar.php") ?>

	<div id="video-homepage">
		<video id="bgvid" playsinline autoplay muted loop>
			<source src="homepage.mp4" type="video/mp4">
		</video>
	</div>

	<!-- Content -->
	<div id="content-homepage">
		<!-- Procedure Box -->
	<div class="order-wrapper">
		<h1>How To Place Order</h1>
		<div class="order-procedure">
			<ul class="procedure-list">
				<li>
					<i class="fas fa-search fa-3x"></i>
					<p>Search for<br>Your Medicines</p>
				</li>
				<li>
					<i class="fas fa-arrow-right fa-3x"></i>
				</li>
				<li>
					<i class="fas fa-map-marker-alt fa-3x"></i>
					<p>Set Your Location</p>
				</li>
				<li>
					<i class="fas fa-arrow-right fa-3x"></i>
				</li>
				<li>
					<i class="fas fa-store fa-3x"></i>
					<p>Find Your <br>Nearby Store</p>
				</li>
				<li>
					<i class="fas fa-arrow-right fa-3x"></i>
				</li>				
				<li>
					<i class="fas fa-clipboard-check fa-3x"></i>
					<p>Reserve Your <br> Medicines</p>
				</li>
			</ul>
		</div>
	</div>


	<!-- Footer -->

	<div class="footer">
		<div class="footer-content">
			<p>Yusra Wasi | Usman Sabir | Muneeb Ahmed Khan</p>
			<p>Copyright © 2008 MediQuick</p>
		</div>
	</div>
	</div>
	

	<script type="text/javascript" src="includes/assets/js/search_script.js"></script>
	<script type="text/javascript">
		var userLoggedIn;

		var vid = document.querySelector('video');

		window.addEventListener('scroll', function(){
			// console.log(pageYOffset);
		  if (pageYOffset < 5) {
				vid.classList.remove("stopfade");
		    vid.play();
		  } else {
				vid.classList.add("stopfade");

		    vid.pause();
		  }
		});

	</script>
</body>
</html>