<!doctype html>
<html>
	<head>
		<title>TopAutoQuote - Compare Auto Insurance Rates</title>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:300,400,300,700">
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

<section id="quote" class="quote-page">
	<div class="container">
		<form id="main-form" action="">
			<div class="form-section">
				<div class="radio row">
					<div class="col-md-5 title">
						Currently Insured?
					</div>
					<div class="col-md-7">
						<label class="radio-inline">
							<input type="radio" name="insured" value="yes"> Yes
						</label>
						<label class="radio-inline">
							<input type="radio" name="insured" value="no"> No
						</label>
					</div>
				</div>
				<div class="radio row">
					<div class="col-md-5 title">
						Home Owner?
					</div>
					<div class="col-md-7">
						<label class="radio-inline">
							<input type="radio" name="homeowner" value="yes"> Yes
						</label>
						<label class="radio-inline">
							<input type="radio" name="homeowner" value="no"> No
						</label>
					</div>
				</div>
			</div>
			<div class="form-section">
				<div class="coverage-selector clearfix">
					<div class="title">
						How much coverage would you like?
					</div>
					<input type="radio" name="coverage-type" id="coverage-state" value="state">
					<label class="coverage-selector-radio" for="coverage-state">
						<div class="selector">
							State Minumum
						</div>
					</label>
					<input type="radio" name="coverage-type" id="coverage-standard" value="standard">
					<label class="coverage-selector-radio" for="coverage-standard">
						<div class="selector">
							Standard Protection
						</div>
					</label>
					<input type="radio" name="coverage-type" id="coverage-superior" value="superior"> 
					<label class="coverage-selector-radio" for="coverage-superior">
						<div class="selector">
							Superior Protection
						</div>
					</label>
				</div>
			</div>
			<div class="form-section">
				<div class="title">
					Primary Vehicle
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="subtitle">
							Year
						</div>
						<select>
							<option>Default</option>
						</select>
					</div>
					<div class="col-md-6">
						<div class="subtitle">
							Make
						</div>
						<select>
							<option>Default</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="subtitle">
							Model
						</div>
						<select>
							<option>Default</option>
						</select>
					</div>
					<div class="col-md-6">
						<div class="subtitle">
							Type
						</div>
						<select>
							<option>Default</option>
						</select>
					</div>
				</div>
			</div>
			<div class="form-section">
				<div class="title">
					Personal Information
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="subtitle">
							First Name
						</div>
						<input type="text" class="form-control" placeholder="First Name">
					</div>
					<div class="col-md-6">
						<div class="subtitle">
							Last Name
						</div>
						<input type="text" class="form-control" placeholder="Last Name">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="subtitle">
							Date of Birth
						</div>
						<input type="email" class="form-control" placeholder="mm/dd/yyyy">
					</div>
					<div class="col-md-6 radio radio-horizontal">
						<div class="row">
							<div class="col-md-5 subtitle">
								Married?
							</div>
							<div class="col-md-7">
								<label class="radio-inline">
									<input type="radio" name="married" value="yes"> Yes
								</label>
								<label class="radio-inline">
									<input type="radio" name="married" value="no"> No
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="subtitle">
							Occupation
						</div>
						<select>
							<option>Default</option>
						</select>
					</div>
					<div class="col-md-6 radio radio-horizontal">
						<div class="row">
							<div class="col-md-5 subtitle">
								Gender?
							</div>
							<div class="col-md-7">
								<label class="radio-inline">
									<input type="radio" name="gender" value="male"> Male
								</label>
								<label class="radio-inline">
									<input type="radio" name="gender" value="female"> Female
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 radio">
						<div class="row">
							<div class="col-md-5 title">
								Credit Score?
							</div>
							<div class="col-md-7">
								<label class="radio-inline">
									<input type="radio" name="creditscore" value="excellent"> Excellent
								</label>
								<label class="radio-inline">
									<input type="radio" name="creditscore" value="good"> Good
								</label>
								<label class="radio-inline">
									<input type="radio" name="creditscore" value="poor"> Poor
								</label>
							</div>
						</div>
					</div>
					<div class="col-md-12 radio">
						<div class="row">
							<div class="col-md-5 title">
								Good Driver?
							</div>
							<div class="col-md-7">
								<label class="radio-inline">
									<input type="radio" name="gooddriver" value="yes"> Yes
								</label>
								<label class="radio-inline">
									<input type="radio" name="gooddriver" value="no"> No
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="subtitle">
							Email
						</div>
						<input type="email" class="form-control" placeholder="Email">
					</div>
					<div class="col-md-6">
						<div class="subtitle">
							Street Address
						</div>
						<input type="text" class="form-control" placeholder="Last Name">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="subtitle">
							Zip Code
						</div>
						<input type="text" class="form-control" placeholder="Zip Code">
					</div>
					<div class="col-md-6">
						<div class="subtitle">
							City
						</div>
						<input type="text" class="form-control" placeholder="City">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="subtitle">
							State
						</div>
						<select>
							<option>Default</option>
						</select>
					</div>
					<div class="col-md-6">
						<div class="subtitle">
							Phone Number
						</div>
						<input type="text" class="form-control" placeholder="000 000 0000">
					</div>
				</div>
			</div>
			<div class="form-section text-center">
				<div class="checkbox">
					<label class="subtitle">
						<input type="checkbox" name="localagent"> I would like a local agent
					</label>
				</div>
				<div class="block">
					Legal info here
					<button type="submit" class="">Get My Quote</button>
				</div>
			</div>
		</form>
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