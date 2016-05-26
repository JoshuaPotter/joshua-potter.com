<?php
	$zipcode = $_GET['zipcode'];
	$url = "http://trusted.jumpsecure.com/?_s=713ae869&_d=38&ZipCode=" . $zipcode;
?>
<!doctype html>
<html>
	<head>
		<title>TopAutoQuote - Compare Auto Insurance Rates</title>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300,700">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/header.css">
		<link rel="stylesheet" href="css/content.css">
		<link rel="stylesheet" href="css/footer.css">
	</head>
	
	<body>
		
		<header id="header">
			<div class="container">
				<div class="row">
					<div class="col-md-4 logo">
						<a href="/"><img src="img/logo.png" class="img-responsive" alt="Logo" /></a>
					</div>
					<div class="col-md-8 slogan">
						Success will always be with you, as long as you place safety as the first priority.
					</div>
				</div>
			</div>
		</header>

		<section id="content" class="quote-page">
			<div class="container">
				<div class="details details-iframe clearfix">
					<?php 
						echo '<iframe id="main-iframe" onload="iframeLoaded()" src="' . $url . '"></iframe>';
					?>
				</div>
			</div>
		</section>
		
		<footer id="footer">
			<div class="container">
				<div class="text-center">
					<img src="img/logo.png" alt="Logo" />
				</div>
				<div class="text-center">
					&copy; 2014 topautoquote.com All Rights Reserved.
				</div>
				<div class="text-center navigation">
					<a href="#">Home</a> | 
					<a href="#">About Us</a> | 
					<a href="#">Contact Us</a> | 
					<a href="#">FAQ</a> | 
					<a href="#">Privacy Policy</a> | 
					<a href="#">Terms and Conditions</a>
				</div>
			</div>
		</footer>
		
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	</body>
</html>