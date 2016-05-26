<?php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $from = 'LucasKriebel.com: ' +  $_POST['email']; 
    $to = 'lucaskriebel@gmail.com';

    $body = "From: $name\n\nE-Mail: $email\n\nMessage:\n$message";

	if ($_POST['submit']) {
		if (mail ($to, $subject, $body, $from)) { 
			header("Location: index.php?sent=1#contact");
		}
		else {
			header("Location: index.php?sent=0#contact");
		}
	}
?>