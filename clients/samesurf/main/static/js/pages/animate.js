$(document).ready(function() {
	$('.pricing_option_box').hover(function() {
		$(this).find('.pricing_button').addClass('animated pulse');
		$(this).find('.pricing_button').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			$(this).removeClass('animated pulse');
		});
	});
	$('.start_now_button').hover(function() {
		$(this).addClass('animated pulse');
		$(this).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			$(this).removeClass('animated pulse');
		});
	});
	$('#cobrowsebutton').hover(function() {
		$(this).addClass('animated pulse');
		$(this).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			$(this).removeClass('animated pulse');
		});
	});
	$('#enablebutton').hover(function() {
		$(this).addClass('animated pulse');
		$(this).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			$(this).removeClass('animated pulse');
		});
	});
	$('#cobrowse-1').hover(function() {
		$(this).addClass('animated pulse');
		$(this).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			$(this).removeClass('animated pulse');
		});
	});
	$('#enablesite-2').hover(function() {
		$(this).addClass('animated pulse');
		$(this).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			$(this).removeClass('animated pulse');
		});
	});
	$('#sameslide-3').hover(function() {
		$(this).addClass('animated pulse');
		$(this).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			$(this).removeClass('animated pulse');
		});
	});
	$('#taketourbox').hover(function() {
		$(this).addClass('animated pulse');
		$(this).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			$(this).removeClass('animated pulse');
		});
	});
	$('#dlappbox2').hover(function() {
		$(this).addClass('animated pulse');
		$(this).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			$(this).removeClass('animated pulse');
		});
	});
	$('#enablesitebox').hover(function() {
		$(this).addClass('animated pulse');
		$(this).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			$(this).removeClass('animated pulse');
		});
	});
	
	$('#grid').waypoint(function() {
		setTimeout(function(){$('.bulletbox').addClass('animated fadeInLeft');},500);
		setTimeout(function(){$('.bulletbox2').addClass('animated fadeInRight');},500);
	}, { offset: '75%' });
	/*$('#grid2').waypoint(function() {
		setTimeout(function(){$('.iconsq1').addClass('animated fadeInLeft');},500);
		setTimeout(function(){$('.iconsq2').addClass('animated fadeInDown');},600);
		setTimeout(function(){$('.iconsq3').addClass('animated fadeInUp');},700);
		setTimeout(function(){$('.iconsq4').addClass('animated fadeInDown');},800);
		setTimeout(function(){$('.iconsq5').addClass('animated fadeInRight');},900);
	}, { offset: '75%' });*/
	
	// home page
	$('#key_uses_box').waypoint(function() {
		setTimeout(function(){$('.circle_1').addClass('animated fadeInDown');},500);
		setTimeout(function(){$('.circle_2').addClass('animated fadeInDown');},600);
		setTimeout(function(){$('.circle_3').addClass('animated fadeInDown');},700);
		setTimeout(function(){$('.circle_4').addClass('animated fadeInDown');},800);
		setTimeout(function(){$('.circle_5').addClass('animated fadeInUp');},800);
		setTimeout(function(){$('.circle_6').addClass('animated fadeInUp');},700);
		setTimeout(function(){$('.circle_7').addClass('animated fadeInUp');},600);
		setTimeout(function(){$('.circle_8').addClass('animated fadeInUp');},500);
	}, { offset: '75%' });
	$('#features_container #grid').waypoint(function() {
		setTimeout(function(){$('.iconsq01').addClass('animated fadeInDown');},900);
		setTimeout(function(){$('.iconsq02').addClass('animated fadeInDown');},800);
		setTimeout(function(){$('.iconsq03').addClass('animated fadeInDown');},700);
		setTimeout(function(){$('.iconsq04').addClass('animated fadeInDown');},600);
		setTimeout(function(){$('.iconsq05').addClass('animated fadeInDown');},500);
		setTimeout(function(){$('.iconsq06').addClass('animated fadeInUp');},500);
		setTimeout(function(){$('.iconsq07').addClass('animated fadeInUp');},600);
		setTimeout(function(){$('.iconsq08').addClass('animated fadeInUp');},700);
		setTimeout(function(){$('.iconsq09').addClass('animated fadeInUp');},800);
		setTimeout(function(){$('.iconsq10').addClass('animated fadeInUp');},900);
	}, { offset: '75%' });
	$('#patent').waypoint(function() {
		setTimeout(function(){$('.c-left').addClass('animated fadeInRight');},500);
		setTimeout(function(){$('.c-right').addClass('animated fadeInLeft');},500);
	}, { offset: '75%' });
	
	// customization & hiw
	$('#content4').waypoint(function() {
		setTimeout(function(){$('.content4view').addClass('animated fadeInUp');},500);
	}, { offset: '75%' });
	
});