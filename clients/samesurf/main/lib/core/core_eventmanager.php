<?php

class core_eventmanager {

	protected $all_listeners;

	public function __constuct() {
		$this->all_listeners = array();
	}

	public function add_event_handler($event, $handler) {
		if (!isset($this->all_listeners[$event])) {
			$this->all_listeners[$event] = array();
		}
		array_push($this->all_listeners[$event], $handler);
	} 

	public function run_event($event) {
		
		$handlers = $this->all_listeners[$event->type];
	
		foreach($handlers as $handler) {
			$handler->process($event);
			if ($event->handled) {
				break;
			}
		} 		
		
		return $event;

	}

}
