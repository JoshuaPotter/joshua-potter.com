$(document).ready(function() {
	
	if($(window).width() <= 1100) {
		$('.tab-recent').click(function() {
			if(!$(this).hasClass('active')) {
				$(this).toggleClass('active');
			}
			$('.tab-popular').removeClass('active');
			$('.tab-shared').removeClass('active');
			
			$('.recent-subs').addClass('show-grid');
			$('.popular-subs').removeClass('show-grid');
			$('.shared-subs').removeClass('show-grid');
		});
		$('.tab-popular').click(function() {
			if(!$(this).hasClass('active')) {
				$(this).toggleClass('active');
			}
			$('.tab-recent').removeClass('active');
			$('.tab-shared').removeClass('active');
			
			$('.recent-subs').removeClass('show-grid');
			$('.popular-subs').addClass('show-grid');
			$('.shared-subs').removeClass('show-grid');
		});
		$('.tab-shared').click(function() {
			if(!$(this).hasClass('active')) {
				$(this).toggleClass('active');
			}
			$('.tab-recent').removeClass('active');
			$('.tab-popular').removeClass('active');
			
			$('.recent-subs').removeClass('show-grid');
			$('.popular-subs').removeClass('show-grid');
			$('.shared-subs').addClass('show-grid');
		});
	}	
	
/* 	var widthThird = $('.tab-selector').innerWidth() / (3.01);
	$('.tab').css({
		width: widthThird
	}); */
	
});

/* $(window).resize(function() {
	var widthThird = $('.tab-selector').innerWidth() / (3.01);
	$('.tab').css({
		width: widthThird
	});
}); */