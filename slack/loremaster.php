<?php

require_once('connect.php');

if(!$conn) { 
	//die('Could not connect: ' . mysql_error());
	$data = array('text' => "I can't access the lore archives right now. I have contacted @josh and the error should be resolved within 48-72 hours.");
}

$token = $_POST['token'];
$trigger = strtolower($_POST['trigger_word']);
$user = strtolower($_POST['user_name']);

if($token != 'ERG5AMSBBAUvEwe1cLxTRHsR'){ 
	$data = array('text' => "The archive is experiencing a security breach. @josh, get in here and fix this shit.");
	//die($msg);
} else {
	if($trigger == "loremaster" || $trigger == "kill me") {
		if(mt_rand(1,100) <= 5) {
			// if probability is less than 5%
			$data = array('text' => "ah, it's yourself!");
		} else {
			if($trigger == "loremaster") {
				$lore = substr($_POST['text'], 10);
			} else {
				$lore = substr($_POST['text'], 7);
			}
			$lore = preg_replace('/\s+/', '', $lore);
			if(strlen($lore) == 0) {
				$sql = "SELECT * FROM lore ORDER BY RAND() LIMIT 1";
			} else if ($lore == "latest") {
				$sql = "SELECT * FROM lore ORDER BY lore_id DESC LIMIT 1";
			} else if ($lore == "stats") {
				$count = mysql_query("SELECT COUNT(*) FROM lore");
				$rows = mysql_fetch_array($count);
				$occurrence = mysql_query("SELECT submitted_by,COUNT(*) as count FROM lore GROUP BY submitted_by ORDER BY count DESC");
				$mostSubmitted = mysql_fetch_array($occurrence);
				$data = array('text' => "There have been *$rows[0]* records added to the grimoire since my introduction to YetiChat on April 26, in the year of our lord, 2016. Patron saint *$mostSubmitted[0]* has contributed the most entries, with *$mostSubmitted[1]* submissions.");
			} else {
				$sql = "SELECT * FROM lore WHERE (lore_id = '" . urlencode(mysql_real_escape_string($lore)) . "' OR submitted_by = '" . urlencode(mysql_real_escape_string($lore)) . "') ORDER BY RAND() LIMIT 1";
			}

			if($lore != "stats") {
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)):
					$data = array('text' =>  "(" . $row['lore_id'] . "): " .  urldecode($row['lore_url']), 'unfurl_links' => true, 'unfurl_media' => true);
				endwhile;
			}
		}
	} else if ($trigger == "\delete") {
		$lore = substr($_POST['text'], 8);
		$lore = preg_replace('/\s+/', '', $lore);
		if(strlen($lore) > 0) {
			$sql = "DELETE IGNORE FROM lore WHERE (lore_id = '" . urlencode(mysql_real_escape_string($lore)) . "' OR lore_url = '" . urlencode(mysql_real_escape_string($lore)) . "') LIMIT 1";
			$result = mysql_query($sql);
			$data = array('text' => "I have removed ($lore) from the archive. Thank you for improving the quality of the grimoire by purging non-iconic lore entries.");
		} else {
			$data = array('text' => "Please give me the lore record number found within parentheses or record url so I may locate and purge the entry (example: \delete 1, \delete www.google.com).");
		}
	} else if ($trigger == "\\") {
		$lore = substr($_POST['text'], 1);
		$lore = preg_replace('/\s+/', '', $lore);
		if(strlen($lore) > 0) {
			if(preg_match("/\b(?:|(?:https?|ftp):\/\/)(?:www\.|)yetichat\.slack\.[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $lore)) {
				$sql = "INSERT INTO lore(lore_url, submitted_by) VALUES".
					  "('" . urlencode(mysql_real_escape_string($lore)) . "', '$user')";
				 
				$result = mysql_query($sql);

				if(! $result ) {
					//die('Could not enter data: ' . mysql_error());
					$data = array('text' => "I have recorded this lore already, m'$user_name");
					//die($msg);
				} else {
					$data = array('text' => "I have successfully transcribed your submission ($lore) to the archives. Thank you, m'$user, for contributing to the preservation of *YetiChat* legacy.");
				}
			} else {
				$data = array('text' => "Only valid slack links are recorded in the grimoire.");
			}
		} else {
			$data = array(
				'text' => "*Usage*: type 'loremaster' or 'kill me' for lore or add slack links to the lore archives; *ex: \https://yetichat.slack.com/archives/xxxxxx/yyyyyy *\n *Search*: Enter the triggers followed by the id number or the user who submitted the quote; *ex: loremaster morgan, kill me 21*"
			);
		}
	}  else if ($trigger == "ragemaster") {
		$input = substr($_POST['text'], 11);
		$input = strtolower($input);
		if(strlen($input) > 0) {
			if($input == "slackbot") {
				$data = array('text' => "fuck slackbot and fuck the pins");
			} else if($input != "josh" && $input != "morgan") {
				$data = array('text' => "fuck $input");
			} else {
				$data = array('text' => "love $input");
			}
		} else {
			if($user != "josh") {
				$data = array('text' => "fuck $user");
			} else {
				$data = array('text' => "love $user");
			}
		}
	} 
}
mysql_close($conn);
header('Content-type:application/json;charset=utf-8');
echo json_encode($data);