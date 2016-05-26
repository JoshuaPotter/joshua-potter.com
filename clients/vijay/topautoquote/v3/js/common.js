$(document).ready(function() {
	$('#step-1-btn .next-step').click(function() {
		$('#step-1-btn').fadeOut(50);
		$('#step-1').fadeOut(250, function() {
			$('#step-2').fadeIn();
			$('#step-2-btn').fadeIn();
		});
	})
	$('#step-2-btn .next-step').click(function() {
		$('#step-2-btn').fadeOut(50);
		$('#step-2').fadeOut(250, function() {
			$('#step-3').fadeIn();
			$('#disclaimer').fadeIn();
			$('#submit').fadeIn();
		});
	})
});