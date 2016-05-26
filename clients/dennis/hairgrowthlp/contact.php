<!doctype html>
<html>

	<head>
		<title>Hair Growth</title>
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="css/fonts/proxima-nova.css" />
		<link href="css/form.css" rel="stylesheet" type="text/css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style type="text/css">
			body {
				background: #ffffff;
			}
			a {
				text-decoration: underline;
				color: #C00;
			}
			a:hover {
				color: #C00;
				text-decoration: none;
			}
			#header {
				color: #C00;
				background: #ffffff;
				text-align: center;
				border-bottom: 1px solid #C00;
			}
			#content {
				margin-top: 0;
				border-radius: 0;
			}
			#content p {
				font-size: 18px;
				line-height: 1.5;
			}
			.bg-primary {
				padding: 10px;
				background: #C00;
			}
			.semi-bold {
				font-weight: 600;
			}
			#main-cta {
				padding: 25px 15px;
				background: #EFC932;
				color: #ffffff;
				min-width: 575px;
				font-size: 35px;
				text-decoration: none !important;
			}
			#main-cta:hover {
				background: #E5C339;
			}
			.btn {
				margin: 0 15px;
				text-align: center;
				display: inline-block;
				border-radius: 5px;
				text-transform: uppercase;
				font-weight: 600;
				-webkit-box-shadow: 0px 8px 0px 0px #DBB92F;
				-moz-box-shadow: 0px 8px 0px 0px #DBB92F;
				box-shadow: 0px 8px 0px 0px #DBB92F;
			}
			.main .book-info {
				margin: 25px 0;
			}
			.published {
				margin: 15px 0;
				font-size: 16px;
				color: #c00;
			}
			@media all and (max-width: 1450px) {
				#main-cta {
					min-width: 500px;
					font-size: 28px;
				}
			}
			@media all and (max-width: 1280px) {
				#main-cta {
					padding: 20px 15px;
					min-width: 400px;
					font-size: 26px;
				}
			}
			@media all and (max-width: 991px) {
				#header {
					padding: 30px 0;
					font-size: 24px;
					line-height: 1.5;
				}
				#content .wrapper {
					padding: 15px 0;
				}
				img {
					margin: 30px auto !important;
					float: none !important;
					display: block;
					max-width: 100%;
					height: auto;
				}
				#main-cta {
					padding: 15px 35px;
					min-width: 0;
					font-size: 28px;
				}
			}
			input,
			textarea {
				margin-bottom:15px;
				padding: 15px;
				border: 1px solid rgba(0,0,0,.125);
				border-radius: 5px;
				width: 100%;
			}
			input[type="submit"] {
				width: 200px;
				margin: 0 auto;
			}
			textarea {
				min-height: 150px;
			}
		</style>
	</head>

	<body style="padding-top: 0;">
		<section id="header">
			<div class="container">
				Contact
			</div>
		</section>
		<section id="content">
			<div class="container">
				<div class="wrapper">
					<div class="section">
						<form class="content" id="form" method="post" action="email.php">
							<input type="text" class="contact-input" name="name" placeholder="Name" />
							<input type="email" class="contact-input" name="email" placeholder="Email Address" />
							<input type="text" class="contact-input" name="subject" placeholder="Subject" />
							<textarea class="contact-textarea" name="message" placeholder="Your message..."></textarea>
							<input id="submit" name="submit" type="submit"  />
						</form>
					</div>
				</div>
			</div>
		</section>
		<footer id="footer">
			<div class="container">
				Copyright &copy; 2015 clicksales Inc. Clickbank/854 Lusk St./Suite 300/ Boise ID85414
			</div>
		</footer>
		<script type="text/javascript">
			function startTimer(duration, display) {
				var timer = duration, minutes, seconds;
				setInterval(function () {
					minutes = parseInt(timer / 60, 10)
					seconds = parseInt(timer % 60, 10);

					minutes = minutes < 10 ? "0" + minutes : minutes;
					seconds = seconds < 10 ? "0" + seconds : seconds;

					display.text(minutes + ":" + seconds);

					if (--timer < 0) {
						timer = duration;
					}
				}, 1000);
			}

			jQuery(function ($) {
				var fiveMinutes = 60 * 5,
					display = $('#time');
				startTimer(fiveMinutes, display);
			});
			$(document).ready(function() {
				$('.payment-radio').change(function() {
					if($(this).attr('id') == "card-radio") {
						$('#card-details').slideDown();
					} else {
						$('#card-details').slideUp();
					}
				});
				$('.close-alert').click(function() {
					$('#alert-bg').fadeOut();
				});
			});
		</script>
	</body>

</html>