// Avoid `console` errors in browsers that lack a console.
(function() {
	var method;
	var noop = function () {};
	var methods = [
		'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
		'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
		'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
		'timeStamp', 'trace', 'warn'
	];
	var length = methods.length;
	var console = (window.console = window.console || {});

	while (length--) {
		method = methods[length];

		// Only stub undefined methods.
		if (!console[method]) {
			console[method] = noop;
		}
	}
}());

// Place any jQuery/helper plugins in here.
var javascript_countdown = function () {
	var time_left = 10; //number of seconds for countdown
	var keep_counting = 1;
	var no_time_left_message = 'few seconds';
	function countdown() {
		if(time_left < 2) {
			keep_counting = 0;
		}
		time_left = time_left - 1;
	}
	function add_leading_zero( n ) {
		if(n.toString().length < 2) {
			return '0' + n;
		} else {
			return n;
		}
	}
	function format_output() {
		var hours, minutes, seconds;
		seconds = time_left % 60;
		minutes = Math.floor(time_left / 60) % 60;
		hours = Math.floor(time_left / 3600);
		seconds = add_leading_zero( seconds );
		minutes = add_leading_zero( minutes );
		hours = add_leading_zero( hours );
		return minutes + ' minutes and ' + seconds + ' seconds';
	}
	function show_time_left() {
		document.getElementById('timer').innerHTML = format_output();
	}
	function no_time_left() {
		document.getElementById('timer').innerHTML = no_time_left_message;
	}
	return {
		count: function () {
			countdown();
			show_time_left();
		},
		timer: function () {
			javascript_countdown.count();
			if(keep_counting) {
				setTimeout("javascript_countdown.timer();", 1000);
			} else {
				no_time_left();
			}
		},
		init: function (n) {
			time_left = n;
			javascript_countdown.timer();
		}
	};
}();
javascript_countdown.init(290);