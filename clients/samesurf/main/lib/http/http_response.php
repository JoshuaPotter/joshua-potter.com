<?php

class http_response {

	private $body;
	private $headers;

	public function __construct() {
		$this->headers = array();
		$this->body = null;
	}

	public function add_header($key, $value) {
		$header = new stdClass();
		$header->key = $key;
		$header->value = $value;
		array_push($this->headers, $header);

	}

	public function append_body($body) {
		if ($this->body == null) $this->body = array();
		array_push($this->body, $body);	
	}

	public function out() {

		if (count($this->headers) == 0 && $this->body == null) {
			return false;
		}

		foreach($this->headers as $header) {
			header("$header->key: $header->value");
		}

		if (isset($this->body)) {
	 		foreach($this->body as $body) {	
				echo $body;
			}
		}
		return true;
	}
}
