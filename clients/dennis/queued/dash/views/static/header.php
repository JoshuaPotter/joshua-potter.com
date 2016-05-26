<?php
require_once 'config.php';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Queued | Dashboard</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

	<!-- jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<!-- bootstrap -->
	<link rel="stylesheet" href="../css/bootstrap.min.css">

	<!-- font awesome -->
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

	<!-- custom css -->
	<link rel="stylesheet" type="text/css" href="../fonts/proxima-nova.css" />
	<link rel="stylesheet" type="text/css" href="css/general.css" />
	<link rel="stylesheet" type="text/css" href="css/header.css" />
	<link rel="stylesheet" type="text/css" href="css/content.css" />
</head>

<body>
	<header id="dash-header">
		<div class="container-fluid">
			<div class="row">
				<div class="masthead">
					<div class="logo">
						<a href="#">
							<img src="../img/logos/queued-lg.png" alt="Logo" />
						</a>
					</div>
					<a href="#" class="btn upgrade-btn"><i class="fa fa-star fa-fw"></i> Upgrade Plan</a>
				</div>
				<div class="col-xs-2 account-dropdown">
					<img src="https://farm9.staticflickr.com/8340/8260117875_67bd7d7889_s.jpg" alt="Your Icon" />My Account
					<i class="fa fa-angle-down fa-lg"></i>
				</div>
			</div>
		</div>
	</header>

	<section id="content" class="clearfix">
		<div id="account-sidebar">
			<div class="add-account">
				<a href="#" class="btn add-account-btn">+ Add Accounts</a>
			</div>
			<div class="account-list">
				<a href="views/pages/content.php" class="account-entry active clearfix" data-toggle="ajax-tab">
					<div class="image">
						<img src="https://farm9.staticflickr.com/8340/8260117875_67bd7d7889_s.jpg" alt="Your Icon" />
					</div>
					<div class="name">
						<div class="handle">Lewis Hamilton</div>
						<div class="type"><i class="fa fa-twitter social-icon"></i> 33</div>
					</div>
				</a>
				<a href="views/pages/content.php" class="account-entry clearfix" data-toggle="ajax-tab">
					<div class="image">
						<img src="https://farm9.staticflickr.com/8340/8260117875_67bd7d7889_s.jpg" alt="Your Icon" />
					</div>
					<div class="name">
						<div class="handle">Lewis Hamilton</div>
						<div class="type"><i class="fa fa-facebook social-icon"></i> 33</div>
					</div>
				</a>
			</div>
		</div>
		<div id="account-actions">
			<div class="account-actions-tabs">
				<ul class="clearfix">
					<li><a href="views/pages/content.php" class="<?php if($currentPage == 'index.php') { echo 'active '; } ?>content-tab ajax-call" data-toggle="ajax-tab"><i class="fa fa-inbox"></i> Content</a>
					</li>
					<li><a href="views/pages/analytics-posts.php" class="<?php if($currentPage == 'analytics-posts.php' || $currentPage == 'analytics-analysis.php') { echo 'active '; } ?>analytics-tab ajax-call" data-toggle="ajax-tab"><i class="fa fa-bar-chart-o"></i> Analytics</a>
					</li>
					<li><a href="views/pages/schedule.php" class="<?php if($currentPage == 'schedule.php') { echo 'active '; } ?>schedule-tab ajax-call" data-toggle="ajax-tab"><i class="fa fa-clock-o"></i> Schedule</a>
					</li>
					<li><a href="views/pages/settings.php" class="<?php if($currentPage == 'settings.php') { echo 'active '; } ?>settings-tab ajax-call" data-toggle="ajax-tab"><i class="fa fa-cog"></i> Settings</a>
					</li>
				</ul>
			</div>