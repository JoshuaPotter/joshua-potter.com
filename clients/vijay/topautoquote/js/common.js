$(document).ready(function() {
	$('#step-1 .next-step').click(function() {
		$('#step-1').fadeOut(250, function() {
			$('#step-2').fadeIn();
		});
	})
	$('#step-2 .next-step').click(function() {
		$('#step-2').fadeOut(250, function() {
			$('#step-3').fadeIn();
			$('#disclaimer').fadeIn();
			$('#submit').fadeIn();
		});
	})
});