$(document).ready(function() {
/* 	$('.header-image').blurjs({
		source: '.header-image',
		radius: 7
	}); */
	var headerHeight = $('#header').innerHeight();
	$(window).scroll(function() {
		var scroll = $(window).scrollTop();
		if(scroll >= (headerHeight - 90)) {
			$('#header').addClass('fixed');
			$('#content').addClass('w-fixed');
			$('#fixed-bg').show().css({
				height: $('#header').height()+20
			});
		}
		else {
			$('#header').removeClass('fixed');
			$('#content').removeClass('w-fixed');
			$('#fixed-bg').hide();
		}
	});
});