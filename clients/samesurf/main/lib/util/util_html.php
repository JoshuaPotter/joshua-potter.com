<?php

class util_html {

public static function attr($name, $object, $key) {
	if (isset($object->$key)) {
		$value = $object->$key;
		echo "$name=\"$value\"";
	}
}

public static function text($object, $key) {
	if (isset($object->$key)) {
		echo $object->$key;
	}	
}

}
