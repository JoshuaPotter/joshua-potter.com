<?php
	if(isset($_POST['g-recaptcha-response'])){
		$captcha=$_POST['g-recaptcha-response'];
	}
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $from = $email; 
    $to = 'hessercharlie@gmail.com';

    $body = "Sent from email form on Greenlight Technologies Website\n\nFrom: $name\nEmail Address: $email\n\nMessage:\n$message";

	if(!$captcha){
		header("Location: contact.php?sent=2");
	}
	else {
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=YOUR SECRET KEY&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		if($response.success==true) {
			if ($_POST['submit']) {
				if (mail ($to, $subject, $body, $from)) { 
					header("Location: contact.php?sent=1");
				}
				else {
					header("Location: contact.php?sent=0");
				}
			}
		}
	}
?>