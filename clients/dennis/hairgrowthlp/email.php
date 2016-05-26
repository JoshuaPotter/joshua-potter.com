<?php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $from = $_POST['email']; 
    $to = 'contact@hairlossfixed.com';

    $body = "From: $name\n\nE-Mail: $email\n\nMessage:\n$message";

	if ($_POST['submit']) {
		if (mail ($to, $subject, $body, $from)) { 
			header("Location: sent.html");
		}
		else {
			header("Location: error.html");
		}
	}
?>