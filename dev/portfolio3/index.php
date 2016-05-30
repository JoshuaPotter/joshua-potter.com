<?php
/*
	Last.FM API: 
	Application name	joshua-potter.com
	API key	b935fbba15b18f756a2c012e19bbae31
	Shared secret	3b4ea08aec8241d8a60f6cf4b83113c5
	Registered to	TLJoshh
*/
?>
	<!doctype html>
	<html lang="en">

	<head>
		<title>Joshua Potter</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href='https://fonts.googleapis.com/css?family=Playfair+Display:700,900' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/stylesheet.css">
		<script src="https://use.typekit.net/upb2xbc.js"></script>
		<script>
			try {
				Typekit.load({
					async: true
				});
			} catch (e) {}
		</script>
		<script src="https://use.fontawesome.com/7424f8b6f5.js"></script>
	</head>

	<body class="fixed-nav">
		<div class="container-fluid">
			<section id="navigation">
				<div class="navigation-interaction"><svg class="nc-icon glyph" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24"><g> <path data-color="color-2" fill="rgba(213,215,227,1)" d="M23,13H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,13,23,13z"></path> <path fill="rgba(213,215,227,1)" d="M23,6H1C0.4,6,0,5.6,0,5s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,6,23,6z"></path> <path fill="rgba(213,215,227,1)" d="M23,20H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,20,23,20z"></path> </g></svg></div>
				<ul id="pages">
					<li><a href="#">Home</a></li>
					<li><a href="#">Works</a></li>
					<li><a href="#">Contact</a></li>
					<li><a href="#">Side Projects</a></li>
				</ul>
				<div id="selected-works" style="display:none;">
					<div class="title">
						Selected Works
					</div>
					<div class="row">
						<div class="col-md-8">
							Appearly
						</div>
						<div class="col-md-4">
							Co-owner &amp; Developer
						</div>
					</div>
				</div>
			</section>
			<section id="page">
				<div class="container-fluid">
					<div class="row" id="header">
						<div class="col-xs-6">
							<h1>
								Joshua Potter
							</h1>
						</div>
						<div class="col-xs-6 text-right">
							<h2>
								Front-End Developer
							</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div id="hero">
								<div class="valign-center">
									<span>Hello,</span>
									<span>I create for web &amp; mobile</span>
								</div>
								<!-- have user add their username, slide up animation -->
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div id="spotifyJs"></div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
		<script src="js/colorthief.js"></script>
		<script src="js/spotify.js"></script>
		<script>
			$(document).ready(function() {
				var lastFmUsername = 'TLJoshh';
				var lastFmKey = 'b935fbba15b18f756a2c012e19bbae31';
				spotifyJs(lastFmUsername, lastFmKey, lastFmUsername, false);
				$('.navigation-interaction').click(function() {
					var navPane = $('#navigation');
					var pagePane = $('#page');
					if ($(window).width() > 1680) {
						if (navPane.hasClass('open')) {
							pagePane.animate({
								marginLeft: "90px"
							}, 1450, "easeOutCubic");
							navPane.animate({
								width: "105px"
							}, 1500, "easeOutQuart");
						} else {
							navPane.animate({
								width: "38%"
							}, 1250, "easeOutCubic");
							pagePane.delay(50).animate({
								marginLeft: "32%"
							}, 1950, "easeOutQuart");
						}
					} else {
						if (navPane.hasClass('open')) {
							pagePane.animate({
								marginLeft: "90px"
							}, 1450, "easeOutCubic");
							navPane.animate({
								width: "105px"
							}, 1500, "easeOutQuart");
						} else {
							navPane.animate({
								width: "40%"
							}, 1250, "easeOutCubic");
							pagePane.delay(50).animate({
								marginLeft: "40%"
							}, 1950, "easeOutQuart");
						}
					}
					if (navPane.hasClass('open')) {
						navPane.removeClass('open');
					} else {
						navPane.addClass('open');
					}
				});
			});
		</script>
	</body>

	</html>