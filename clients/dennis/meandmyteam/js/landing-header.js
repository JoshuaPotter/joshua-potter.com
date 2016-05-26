$(document).ready(function() {
	var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ? true : false;

	if(!isMobile) {
		$('.various').fancybox({
			fitToView	: false,
			width		: '70%',
			height		: '80%',
			autoSize	: false,
			closeClick	: false,
			openEffect	: 'fade',
			closeEffect	: 'fade',
			iframe : {
				preload: false
			}
		});
	}
	
	if($(window).width() <= 1100) {
		$('.landing-nav-responsive-button').click(function() {
			$('#landing-responsive-nav').slideToggle();
		});
		$('.close-get-podium').click(function() {
			$('#get-podium').slideToggle();
		});


		$(document).on('scroll',function() {
			if($(document).scrollTop() > 70) {
				$('#get-podium').addClass('fixed');
				$('#mobile-header').css({
					marginBottom: 82
				});
			}
			else {
				$('#get-podium').removeClass('fixed');
				$('#mobile-header').css({
					marginBottom: 0
				});
			}
		});
	}

});