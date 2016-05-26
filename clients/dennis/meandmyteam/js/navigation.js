$(document).ready(function() {
	// fade in nav
	$('.nav-button').click(function() {
		$('.nav-menu').fadeToggle(500);
	});
	$('#content').click(function() {
		$('.nav-menu').fadeOut(250);
	});
	
	// resize nav on sign-out hover
	$('.signout').hover(function() {
		$('.nav-menu').css({
			paddingBottom: 30
		});
	}, function() {
		$('.nav-menu').css({
			paddingBottom: 15
		});
	});

	// resize on scroll
	$(document).on('scroll',function() {
		if($(document).scrollTop() > 10) {
			$('#fixed-nav').addClass('resize');
		}
		else {
			$('#fixed-nav').removeClass('resize');
		}
	});

});