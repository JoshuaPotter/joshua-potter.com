<?php

class message_smtp {

	protected static function bencode($string) {
		return "=?UTF-8?B?" . base64_encode($string) ."?=";
    }

	public static function send($to, $from, $subject, $content) {

		$header = "From: "  . $from . "\r\n";
		$header .= "Reply-To:" . $from . "\r\n";
		$header .= "Content-Type: multipart/alternative; boundary=\"goldfinch-alt-boundary\"";
		
	 	$hsubject = self::bencode($subject); 	

		mail($to, $hsubject, $content, $header);

	}

}
