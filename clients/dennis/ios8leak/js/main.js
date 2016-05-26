$(document).ready(function() {
	$('.button').hover(function() {
		$(this).addClass('animated pulse');
	}, function() {
		$('.button').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			$(this).removeClass('animated pulse');
		});
	});
	
	$(".carousel").owlCarousel({
		items : 5,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [979,3],
		navigation : true
	});
	
	$('#feature2').waypoint(function() {
		setTimeout(function(){$('.features2-1').addClass('animated fadeInRight');},500);
		setTimeout(function(){$('.features1-1').addClass('animated fadeInRight');},750);
	}, { offset: '75%' });
	$('#feature3').waypoint(function() {
		setTimeout(function(){$('.features2-2').addClass('animated fadeInLeft');},500);
		setTimeout(function(){$('.features1-2').addClass('animated fadeInLeft');},750);
	}, { offset: '75%' });
	$('#health').waypoint(function() {
		setTimeout(function(){$('.heading').addClass('animated fadeInDown');},500);
		setTimeout(function(){$('.col-md-4').addClass('animated fadeInUp');},1100);
	}, { offset: '75%' });
});