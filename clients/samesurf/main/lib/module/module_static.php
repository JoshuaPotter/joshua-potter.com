<?php

class module_static implements core_eventhandler {

	public function process($event) {
		$request = $event->in;
		$components = explode('/', $request->uri);

		if (isset($components[1]) && $components[1] == "static") {
			$event->handled = true;
		}	

		if ($request->uri == "/favicon.ico") {
			$event->handled = true;
		}
	}

}
