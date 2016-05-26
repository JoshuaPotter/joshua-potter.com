$(document).ready(function() {
	$('#preview').click(function() {
		$('#settings').animate({
			left: 0
		});
		$('#back').fadeIn(150);
	});
	$('#back').click(function() {
		$('#settings').animate({
			left: '100%'
		});
		$('#back').fadeOut(100);
	});
	$('#animateButton').click(function() {
		$(this).fadeOut(250);
	});
});