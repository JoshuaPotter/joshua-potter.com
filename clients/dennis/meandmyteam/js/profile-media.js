$(document).ready(function() {
	
	// fade out image opacity on scroll
	$(document).on('scroll',function() {
		var topNum = $(document).scrollTop();
		if($(document).scrollTop() > 1 && $(document).scrollTop() <= 100 ) {
			$('.gradient').css({
				opacity: 50+topNum
			});
		}
		else if($(document).scrollTop() > 100) {
			$('.gradient').css({
				opacity: 100
			});
		}
		else {
			$('.gradient').css({
				opacity: 0
			});
		}
		
	});

});