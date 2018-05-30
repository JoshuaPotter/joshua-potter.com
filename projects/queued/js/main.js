$(document).ready(function() {
	$('#toggle-label').click(function() {
		if( $('.yearly-price').is(':visible') ) {
			$('.yearly-price').hide();
			$('.monthly-price').show();
		} else {
			$('.yearly-price').show();
			$('.monthly-price').hide();
		}
	});
});