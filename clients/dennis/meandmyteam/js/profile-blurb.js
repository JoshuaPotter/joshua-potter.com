$(document).ready(function() {
	
	// stick to top on scroll
	if($(window).width() > 990) {
		$(document).on('scroll',function() {
			var topNum = $(document).scrollTop();
			if($(document).scrollTop() < 0) {
				$('.profile-blurb').css({
					top: 130
				});
			}
			else if($(document).scrollTop() < 39) {
				$('.profile-blurb').css({
					top: 130-topNum
				});
			}
			else {
				$('.profile-blurb').css({
					top: 90
				});
			}

			// fade out if too close to bottom
			if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
				$('.profile-blurb').fadeOut(150);
			}
			else if($(window).scrollTop() + $(window).height() < $(document).height() - 100) {
				$('.profile-blurb').fadeIn(300);
			}
		});
	}
	
	// show/hide info
	var n = 0;
	$('.more-less').click(function() {
		if(n % 2 === 0) {
			$('.bio-p').slideToggle(500, function() {
				$(this).css({
					opacity: 1
				});
			});
		}
		else {
			$('.bio-p').css({
				opacity: 0
			});
			$('.bio-p').delay(500).slideToggle(500);
		}
		n++;
	});
	
	// swap text
	var button = $('.more-less');
	button.on('click', function() {
		var el = $(this);
		if (el.text() == el.data('text-swap')) {
			el.text(el.data('text-original'));
		} else {
			el.data('text-original', el.text());
			el.text(el.data('text-swap'));
		}
	});

});