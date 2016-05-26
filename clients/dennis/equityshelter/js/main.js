$(document).ready(function() {
	$('.nav-button').click(function() {
		$('.navigation').slideToggle();
	});
	$('.newsticker').newsTicker({
		row_height: 15,
		max_rows: 1,
		direction: 'up',
		speed: 600,
		duration: 3000,
		autostart: 1,
		pauseOnHover: 1
	});
});