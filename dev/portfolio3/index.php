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
		<meta charset="utf-8">

		<meta name="description" content="Joshua Potter develops creative websites for others" />
		<meta name="author" content="Joshua Potter" />
		<meta name="copyright" content="Joshua Potter" />
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<meta property="og:title" content="Portfolio of Joshua Potter" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://www.joshua-potter.com/" />
		<meta property="og:image" content="http://i.imgur.com/Q4h6wwK.png" />
		<!-- 180x110 Image for Linkedin -->
		<meta property="og:image:width" content="180" />
		<meta property="og:image:height" content="110" />
		<meta property="og:image" content="http://i.imgur.com/Q4h6wwK.png" />
		<!-- 600x315 Image for Facebook -->
		<meta property="og:image:width" content="600" />
		<meta property="og:image:height" content="315" />
		<meta property="og:image" content="http://i.imgur.com/Q4h6wwK.png" />
		<meta property="og:description" content="Joshua Potter develops creative websites for others" />

		<title>Joshua Potter</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href='https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/jquery.spotify.css">
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
		<nav>
			<div class="navigation-interaction"><svg class="nc-icon glyph" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24"><g> <path data-color="color-2" fill="rgba(213,215,227,1)" d="M23,13H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,13,23,13z"></path> <path fill="rgba(213,215,227,1)" d="M23,6H1C0.4,6,0,5.6,0,5s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,6,23,6z"></path> <path fill="rgba(213,215,227,1)" d="M23,20H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,20,23,20z"></path> </g></svg></div>
			<ul id="pages">
				<li><a href="#home">Home</a></li>
				<li><a href="#skills">Skills</a></li>
				<li><a href="#work">Works</a></li>
				<li><a href="mailto:hello@joshua-potter.com" class="navigation-interaction">Contact</a></li>
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
		</nav>
		<section id="pane">
			<header class="clearfix">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-6">
							<h1>Joshua Potter</h1>
						</div>
						<div class="col-xs-6 text-right">
							<h2>Front-End Developer</h2>
						</div>
					</div>
				</div>
			</header>
			<section id="home" class="clearfix">
				<div class="page">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="hero">
									<div class="valign-center">
										<span>Hello,</span>
										<span>I create for web &amp; mobile</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div id="spotify"></div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section id="skills" class="clearfix">
				<div class="page">
					<div class="container-fluid">
						<div class="hero">
							<div class="valign-center">
								<div class="row">
									<div class="col-md-12">
										I'm a 21 year old based in Tallahassee, Florida with a knack for web development and the <a href="img/life-of-frontend-developer.jpg" target="_blank" data-source="http://www.skilledup.com/articles/life-front-end-web-developer-infographic" data-toggle="tooltip" data-placement="top" title="Source: SkilledUp.com">front-end</a> experience. I'm currently seeking my bachelor of science in computer science. If you're interested in working together, <a href="mailto:hello@joshua-potter.com" class="contact">contact me</a>.
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										I have experience in many levels of the modern web stack.
									</div>
									<!--
									<div class="col-md-12">
										* (source: <a href="http://www.skilledup.com/articles/life-front-end-web-developer-infographic" target="_blank">skilledup</a>)
									</div>
									-->
								</div>
								<div class="row">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
										<h3>
											Area of Focus
										</h3>
										<ul>
											<li>Web consulting &amp; development</li>
											<li>Responsive, mobile-first</li>
											<li>API integration</li>
											<li>Server management (Unix)</li>
										</ul>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
										<h3>
											Client-side
										</h3>
										<ul>
											<li>HTML 5</li>
											<li>CSS 3, Sass</li>
											<li>JavaScript, jQuery, AJAX</li>
											<li>Bootstrap, Foundation, etc.</li>
										</ul>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-2">
										<h3>
											Server-side
										</h3>
										<ul>
											<li>Apache</li>
											<li>PHP</li>
											<li>MySQL</li>
											<li>Ruby</li>
											<li>Node.js</li>
										</ul>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-2">
										<h3>
											Platforms
										</h3>
										<ul>
											<li>GitHub</li>
											<li>Wordpress</li>
											<li>Heroku</li>
											<li>Slack</li>
											<li>Various IDEs</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section id="work" class="clearfix">
				<div class="page">
					<div class="container-fluid">
						<div class="hero">
							<div class="valign-center">
								<div class="row">
									<div class="col-md-12">
										I know how much effort a designer puts into creating a beautiful user interface and an accessible, fluid layout. I focus on converting designs to pixel perfect, responsive websites that work on all devices.
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<ul>
											<li>
												<div class="row">
													<div class="col-md-6 title valign">
														<a href="#">Appearly</a>
													</div>
													<div class="col-md-6 role valign">
														Co-Founder &amp; Developer
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 date">
														January 2014 - Present
													</div>
													<div class="col-md-6 website">
														<a href="//appearlythemes.com" target="_blank">appearlythemes.com</a>
													</div>
												</div>
											</li>
											<li>
												<div class="row">
													<div class="col-md-6 title valign">
														<a href="#">spotifyJS</a>
													</div>
													<div class="col-md-6 role valign">
														Developer
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 date">
														Summer 2016
													</div>
													<div class="col-md-6 website">
														<a href="//joshua-potter.com/spotifyJS" target="_blank">joshua-potter.com/spotifyjs</a>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</section>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
		<script src="js/jquery.smoothscroll.min.js"></script>
		<script src="js/colorthief.js"></script>
		<script src="js/jquery.spotify.js"></script>
		<script src="https://squaresend.com/squaresend.js"></script>
		<script>
			$(document).ready(function() {
				$('#spotify').spotifyJS({
					lastFmUsername: 'TLJoshh',
					lastFmKey: 'b935fbba15b18f756a2c012e19bbae31',
					spotifyUsername: 'tljoshh',
					//adaptiveColors: false
				});
				$('.navigation-interaction').click(function() {
					var navPane = $('nav');
					var pagePane = $('#pane');
					var header = $('header');
					var home = $('#home');
					if (!navPane.hasClass('open')) {
						navPane.addClass('animating');
					}
					if ($(window).width() > 1680) {
						if (navPane.hasClass('open')) {
							pagePane.animate({
								marginLeft: "105px"
							}, 800, "easeOutCubic");
							header.animate({
								marginLeft: "105px"
							}, 800, "easeOutCubic");
							navPane.animate({
								width: "105px"
							}, 800, "easeOutQuart");
							navPane.removeClass('open');
						} else {
							navPane.animate({
								width: "38%"
							}, 800, "easeOutCubic");
							header.delay(50).animate({
								marginLeft: "32%"
							}, 1150, "easeOutQuart");
							pagePane.delay(50).animate({
								marginLeft: "32%"
							}, 1150, "easeOutQuart", function() {
								navPane.addClass('open');
								navPane.removeClass('animating');
							});
						}
					} else {
						if (navPane.hasClass('open')) {
							pagePane.animate({
								marginLeft: "105px"
							}, 800, "easeOutCubic");
							header.animate({
								marginLeft: "105px"
							}, 800, "easeOutCubic");
							navPane.animate({
								width: "105px"
							}, 850, "easeOutQuart");
							navPane.removeClass('open');
						} else {
							navPane.animate({
								width: "40%"
							}, 800, "easeOutCubic");
							header.delay(50).animate({
								marginLeft: "40%"
							}, 1100, "easeOutQuart");
							pagePane.delay(50).animate({
								marginLeft: "40%"
							}, 1100, "easeOutQuart", function() {
								navPane.addClass('open');
								navPane.removeClass('animating');
							});
						}
					}
				});
				$('a').smoothScroll({
					easing:'easeOutQuart',
					speed: 1100
				});
				$('[data-toggle="tooltip"]').tooltip();
			});
		</script>
	</body>

	</html>