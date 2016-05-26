<!doctype html>
<html lang="en">
	<head>
		<title>Contact - Greenlight Technologies</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

		<!-- custom css -->
		<link rel="stylesheet" type="text/css" href="css/general.css" />
		<link rel="stylesheet" type="text/css" href="css/navigation.css" />
		<link rel="stylesheet" type="text/css" href="css/header.css" />
		<link rel="stylesheet" type="text/css" href="css/content.css" />
		<link rel="stylesheet" type="text/css" href="css/footer.css" />

		<!-- font awesome -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		
		<!-- google font -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>

		<!-- jquery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="js/jquery.parallax.min.js"></script>
		
		<!-- recaptcha -->
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>

	<body>
		
		<nav id="navigation">
			<div class="container">
				<div class="row">
					<div class="col-md-6 logo">
						<a class="logo-span" href="#"><img src="img/logo.png" alt="Logo" /> <span>Greenlight Technologies</span></a>
					</div>
					<div class="col-md-6 links">
						<div class="responsive-nav-btn">
							<i class="fa fa-bars"></i>
						</div>
						<ul id="main-nav">
							<li><a href="index.php">Home</a></li>
							<li><a href="about.php">About</a></li>
							<li><a href="contact.php">Contact</a></li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
		
		<header id="header" data-parallax="scroll" data-image-src="img/header-compressor.jpg">
			<div class="container">
				<h2>
					Contact Us
				</h2>
			</div>
		</header>
		
		<section id="content">
			<div class="block light contact-us">
				<div class="container">
					<h2>
						Contact Us
					</h2>
					<div class="row" id="contact">
						<div class="col-md-9 email-us">
							<h3>
								Email Us
							</h3>
							<?php
$sent = $_GET['sent'];
if(isset($sent)) {
	if ($sent == 1) {
		echo '<div class="result sent">Your message has been sent!</div>';
	} 
	else if ($sent == 0) { 
		echo '<div class="result error">Something went wrong, go back and try again!</div>'; 
	}
	else if ($sent == 2) { 
		echo '<div class="result error">Please check the captcha box and try again!</div>'; 
	}
}
?>
							<form id="contact-form" class="row" method="post" action="email-submission.php">
								<div class="col-md-5">
									<input type="text" class="contact-input" name="name" placeholder="Name" />
									<input type="email" class="contact-input" name="email" placeholder="Email Address" />
									<input type="text" class="contact-input" name="subject" placeholder="Subject" />
									
									<div class="g-recaptcha" data-sitekey="6LcLHgETAAAAAGSrwJ5Z24rU3Efq8nUYNtXaaX5G"></div>
								</div>
								<div class="col-md-7">
									<textarea class="contact-textarea" name="message" placeholder="Your message..."></textarea>
									<input id="submit" name="submit" type="submit" class="btn btn-primary" />
								</div>
							</form>
						</div>
						<div class="col-md-3 write-us text-left">
							<h3>
								Write Us
							</h3>
							Address
							<address>
								<i>
									2 McLaughlin Dr. Rye <br/>
									NH, 03870<br/> 
									USA<br/>
								</i>
							</address>
							Phone<br/>
							<i>(603)-918-0827</i>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<footer id="footer">
			<div class="container">
				<p>
					&copy; Greenlight Technologies 2015.
				</p>
				<p>
					Website developed by <a href="mailto:josh@uselunar.com">Lunar Web Development</a>
				</p>
			</div>
		</footer>
		
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
		<script src="js/main.js"></script>
		
	</body>
</html>