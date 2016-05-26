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
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0" />
        <script type="text/javascript">
        (function(doc)
        {
            var addEvent = 'addEventListener',
            type = 'gesturestart',
            qsa = 'querySelectorAll',
            scales = [1, 1],
            meta = qsa in doc ? doc[qsa]('meta[name=viewport]') : [];

            function fix() 
            {
                meta.content = 'width=device-width,minimum-scale=' + scales[0] + ',maximum-scale=' + scales[1];
                doc.removeEventListener(type, fix, true);
            }

            if ((meta = meta[meta.length - 1]) && addEvent in doc)
            {
                fix();
                scales = [.25, 1.6];
                doc[addEvent](type, fix, true);
            }
        }(document));
        </script>
    	<title>songsly.com, Songsly.</title>
    	<meta name="author" content="" />
    	<meta name="keywords" content="" />
    	<meta name="description" content="" />
    	<link type="text/css" href="<?php echo WWW; ?>assets/css/reset.css" media="screen, projection" rel="stylesheet" />
    	<link type="text/css" href="<?php echo WWW; ?>assets/css/style.css" media="screen, projection" rel="stylesheet" />
    	<link type="text/css" href="<?php echo WWW; ?>assets/css/responsive.css" media="screen, projection" rel="stylesheet" />
        <!--<link type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,800italic,300,400,600,700,800" rel="stylesheet" />-->
        <script type="text/javascript" src="<?php echo WWW; ?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo WWW; ?>assets/js/script.js"></script>
        <?php if($uri[2] == '' OR $uri[2] == 'index.php' OR $uri[2] == '?user=true' OR $uri[2] == 'index.php?user=true') { ?>
            <script type="text/javascript">
            $(document).ready(function() {
                home_scroll();
                home_lightbox();
                user_notifications();
                mobile_navigation();
            });
            
            $(window).scroll(function() {
                home_nav();
            });
            </script>
        <?php } else { ?>
            <script type="text/javascript">
            $(document).ready(function() {
                home_scroll();
                home_lightbox();
                user_notifications();
                mobile_navigation();
            });
            </script>
        <?php } ?>
    </head>
    <body<?php echo ($uri[2] == '' OR $uri[2] == 'index.php' OR $uri[2] == '?user=true' OR $uri[2] == 'index.php?user=true') ? ' class="index"' : ' class="pages"';?>>
        <div id="header">
            <div class="container">
                <div class="mobile-navigation">
                    <a href="#mobile-navigation" title="Mobile Navigation" rel="nofollow">Mobile Navigation</a>
                </div>
                <div class="h1">
                    <h1 title="Songsly"><a href="<?php echo WWW; ?>" title="Songsly">Songsly</a></h1>
                </div>
                <div class="slogan">
                    <strong>Songsly</strong> is an <strong>advertising platform</strong> for musicians and video publishers
                </div>
                <ul class="navigation">
                    <li><a class="local" href="<?php echo ($uri[2] == '' OR $uri[2] == 'index.php' OR $uri[2] == '?user=true' OR $uri[2] == 'index.php?user=true') ? '' : WWW; ?>#why-songsly" title="Why Songsly?">Why Songsly?</a></li>
                    <li><a class="local" href="<?php echo ($uri[2] == '' OR $uri[2] == 'index.php' OR $uri[2] == '?user=true' OR $uri[2] == 'index.php?user=true') ? '' : WWW; ?>#how-it-works" title="How Does It Work?">How Does It Work?</a></li>
                    <li><a class="local" href="<?php echo ($uri[2] == '' OR $uri[2] == 'index.php' OR $uri[2] == '?user=true' OR $uri[2] == 'index.php?user=true') ? '' : WWW; ?>#another-feature" title="Another Feature">Another Feature</a></li>
                    <li><a class="local" href="<?php echo ($uri[2] == '' OR $uri[2] == 'index.php' OR $uri[2] == '?user=true' OR $uri[2] == 'index.php?user=true') ? '' : WWW; ?>#another-feature2" title="Another Feature">Another Feature</a></li>
                    <li><a<?php echo ($uri[2] == 'about.php' OR $uri[2] == 'about.php?user=true') ? ' class="current"' : ''; ?> href="<?php echo WWW; ?>about.php" title="About">About</a></li>
                </ul>
                <div class="account<?php echo (!isset($_GET['user'])) ? ' logged-out' : ' logged-in'; ?>">
                    <?php if(!isset($_GET['user'])) { ?>
                        <a class="login" href="#login" title="Login">Login</a>
                        <a class="button<?php echo ($uri[2] == 'sign-up.php' OR $uri[2] == 'sign-up.php?user=true') ? ' current' : ''; ?>" href="<?php echo WWW; ?>sign-up.php" title="Sign Up">Sign Up</a>
                    <?php } else { ?>
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
                    <?php } ?>
                </div>
            </div>
        </div>
        <div id="wrapper">
            <ul class="mobile-navigation">
                <li><a href="about.php" title="How It Works">How It Works</a></li>
                <li><a href="about.php" title="About Us">About Us</a></li>
                <li><a href="help-support.php" title="Help &#38; Support">Help &#38; Support</a></li>
                <li><a href="blog.php" title="Blog">Blog</a></li>
                <li><a href="privacy-terms.php" title="Privacy &#38; Terms">Privacy &#38; Terms</a></li>
            </ul>