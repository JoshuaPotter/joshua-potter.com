<?php
// constants for development mode
define('WWW', '');

// uri for development mode
$uri = explode('/', $_SERVER['REQUEST_URI']);
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title>songsly.com, Songsly.</title>
		<meta name="author" content="" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link type="text/css" href="<?php echo WWW; ?>assets/css/dashboard/reset.css" media="screen, projection" rel="stylesheet" />
		<link type="text/css" href="<?php echo WWW; ?>assets/css/dashboard/style.css" media="screen, projection" rel="stylesheet" />
		<link type="text/css" href="<?php echo WWW; ?>assets/css/dashboard/responsive.css" media="screen, projection" rel="stylesheet" />
		<?php if($uri[2] == 'dashboard_earnings.php' OR $uri[2] == 'dashboard_earnings.php?musician=true' OR $uri[2] == 'dashboard_campaigns.php' OR $uri[2] == 'dashboard_campaigns.php?musician=true' OR $uri[2] == 'dashboard_campaign-musician.php' OR $uri[2] == 'dashboard_campaign-musician.php?musician=true') { ?>
		<link type="text/css" href="<?php echo WWW; ?>assets/css/dashboard/graph.css" media="screen, projection" rel="stylesheet" />
		<?php } ?>
		<?php if($uri[2] == 'dashboard_create-campaign.php' OR $uri[2] == 'dashboard_create-campaign.php?musician=true') { ?>
		<link type="text/css" href="<?php echo WWW; ?>assets/css/dashboard/range.css" media="screen, projection" rel="stylesheet" />
		<?php } ?>
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<link type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,800italic,300,400,600,700,800" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo WWW; ?>assets/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo WWW; ?>assets/js/script.js"></script>
		
		<script type="text/javascript" src="<?php echo WWW; ?>assets/js/dashboard/jquery.chart.js"></script>
		<script type="text/javascript" src="<?php echo WWW; ?>assets/js/dashboard/raphael/raphael-min.js" charset="utf-8"></script>
		<script type="text/javascript" src="<?php echo WWW; ?>assets/js/dashboard/jquery.mapael.js" charset="utf-8"></script>
		<script type="text/javascript" src="<?php echo WWW; ?>assets/js/dashboard/maps/world_countries.js" charset="utf-8"></script>
		
		<?php if($uri[2] == 'dashboard_earnings.php' OR $uri[2] == 'dashboard_earnings.php?musician=true' OR $uri[2] == 'dashboard_campaigns.php' OR $uri[2] == 'dashboard_campaigns.php?musician=true' OR $uri[2] == 'dashboard_campaign-musician.php' OR $uri[2] == 'dashboard_campaign-musician.php?musician=true') { ?>
		<script type="text/javascript" src="<?php echo WWW; ?>assets/js/dashboard/jquery.chart.js"></script>
		<script type="text/javascript" src="<?php echo WWW; ?>assets/js/dashboard/raphael/raphael-min.js" charset="utf-8"></script>
		<script type="text/javascript" src="<?php echo WWW; ?>assets/js/dashboard/jquery.mapael.js" charset="utf-8"></script>
		<script type="text/javascript" src="<?php echo WWW; ?>assets/js/dashboard/maps/world_countries.js" charset="utf-8"></script>
		<?php } ?>
		<?php if($uri[2] == 'dashboard_create-campaign.php' OR $uri[2] == 'dashboard_create-campaign.php?musician=true') { ?>
		<script type="text/javascript" src="<?php echo WWW; ?>assets/js/dashboard/jquery.tools.min.js"></script>
		<?php } ?>
		<script type="text/javascript" src="<?php echo WWW; ?>assets/js/dashboard/script.js"></script>
		<?php if($uri[2] == 'dashboard_settings.php' OR $uri[2] == 'dashboard_settings.php?musician=true') { ?>
		<script type="text/javascript">
			$(document).ready(function() {
				user_notifications();
				checkbox_toggle();
				connected_toggle();
			});
		</script>
		<?php } elseif($uri[2] == 'dashboard_create-campaign.php' OR $uri[2] == 'dashboard_create-campaign.php?musician=true') { ?>
		<script type="text/javascript">
			$(document).ready(function() {
				user_notifications();
				campaign_type();
				$(':range').rangeinput({progress: true});

				/* available budget dollar sign */
				$('input#available_budget').val('$' + $('input#available_budget').val());

				$('input#available_budget').change(function() {
					$(this).val('$' + $(this).val());
				});
			});
		</script>
		<?php } else { ?>
		<script type="text/javascript">
			$(document).ready(function() {
				user_notifications();
				campaign_apply(); // put this for campaign youtuber page only
				campaign_settings(); // put this for campaign musician page only
				campaign_reaached_last(); // put this for campaign musician page only
			});
		</script>
		<?php } ?>
	</head>
	<body>
		<div class="sidebar">
			<h1 title="Songsly"><a href="<?php echo WWW; ?>" title="Songsly">Songsly</a></h1>
			<div class="user">
				<a class="user-notifications" href="#user" title="Dennis Hegstad">
					<img src="<?php echo WWW; ?>assets/images/dashboard/sidebar-user.jpg" alt="Dennis Hegstad" />
					<span class="notifications">2</span>
				</a>
				<div class="notifications">
					<h3>Notifications</h3>
					<div class="user-actions">
						<a href="<?php echo WWW; ?>dashboard_settings.php" title="Settings">Settings</a>
						<a href="#logout" title="Log Out">Log Out</a>
					</div>
					<ul>
						<li class="new">
							<div class="user-photo"><a href="#user"><img src="<?php echo WWW; ?>assets/images/dashboard/sidebar-user.jpg" alt="Dennis Hegstad" /></a></div>
							<div class="notification">
								<p>
									<strong>Alex Cican</strong> has applied to your <strong>Shakalaka Campaign</strong>
								</p>
								<a class="action approved" href="#approve" title="Approve"><span></span>Approve</a>
								<a class="action rejected" href="#reject" title="Reject"><span></span>Reject</a>
								<span class="date right">Yesterday</span>
							</div>
						</li>
						<li class="new">
							<div class="user-photo"><a href="#user"><img src="<?php echo WWW; ?>assets/images/dashboard/sidebar-user.jpg" alt="Dennis Hegstad" /></a></div>
							<div class="notification">
								<p>
									<strong>Alex Cican</strong> has applied to your <strong>Shakalaka Campaign</strong>
								</p>
								<a class="action approve" href="#approve" title="Approve"><span></span>Approve</a>
								<a class="action reject" href="#reject" title="Reject"><span></span>Reject</a>
								<span class="date right">6/04/3014</span>
							</div>
						</li>
						<li>
							<div class="user-photo"><a href="#user"><img src="<?php echo WWW; ?>assets/images/dashboard/sidebar-user.jpg" alt="Dennis Hegstad" /></a></div>
							<div class="notification">
								<p>
									You earned <strong>$38.98</strong> today. Your new total is <strong>$5,684.89</strong>
								</p>
								<span class="date">5/04/3014</span>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<ul class="navigation">
				<li class="home<?php echo ($uri[2] == 'dashboard_index.php' OR $uri[2] == 'dashboard_index.php?musician=true') ? ' current' : ''; ?>"><a href="<?php echo WWW; ?>dashboard_index.php" title="Home">Home</a></li>
				<?php if(!isset($_GET['musician'])) { ?>
				<li class="earnings<?php echo ($uri[2] == 'dashboard_earnings.php' OR $uri[2] == 'dashboard_earnings.php?musician=true') ? ' current' : ''; ?>"><a href="<?php echo WWW; ?>dashboard_earnings.php" title="Earnings">Earnings</a></li>
				<?php } else { ?>
				<li class="campaigns<?php echo ($uri[2] == 'dashboard_campaigns.php' OR $uri[2] == 'dashboard_campaigns.php?musician=true') ? ' current' : ''; ?>"><a href="<?php echo WWW; ?>dashboard_campaigns.php" title="Campaigns">Campaigns</a></li>
				<?php } ?>
				<li class="settings<?php echo ($uri[2] == 'dashboard_settings.php' OR $uri[2] == 'dashboard_settings.php?musician=true') ? ' current' : ''; ?>"><a href="<?php echo WWW; ?>dashboard_settings.php" title="Settings">Settings</a></li>
				<li class="help<?php echo ($uri[2] == 'dashboard_help.php' OR $uri[2] == 'dashboard_help.php?musician=true') ? ' current' : ''; ?>"><a href="<?php echo WWW; ?>dashboard_help.php" title="Help">Help</a></li>
			</ul>
		</div>
		<div class="page<?php echo ($uri[2] == 'dashboard_settings.php' OR $uri[2] == 'dashboard_settings.php?musician=true' OR $uri[2] == 'dashboard_create-campaign.php' OR $uri[2] == 'dashboard_create-campaign.php?musician=true') ? ' settings' : ' pages'; ?>">