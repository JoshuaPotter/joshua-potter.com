$(document).ready(function() {
	'use strict';

	function minifyNav() {
		if($(window).scrollTop() > 200) {
			$('.navbar-nav').addClass('slide');
			$('.navbar-right').addClass('active');
		} else {
			$('.navbar-nav').removeClass('slide');
			$('.navbar-right').removeClass('active');
		}
	}

	function showNavSearch() {
		if($('.navbar-search-form').hasClass('active')) {
			$('.navbar-search-form').removeClass('active');
			$('.navbar-right .post-title').removeClass('slide');
			$('.navbar-right .post-heading').removeClass('slide');
		} else {
			$('.navbar-search-form').addClass('active');
			$('.navbar-right .post-title').addClass('slide');
			$('.navbar-right .post-heading').addClass('slide');
		}
	}
	
	function fixNavPosition() {
		var top = $(window).scrollTop();
		var nav = $('#navigation');
		nav.css('top', top + 'px');
	}

	function adaptiveColors() {
		var img = document.createElement('img');
		img.setAttribute('src', $('#post .post-container img:nth-of-type(1)').attr('src'));
		img.addEventListener('load', function() {
			var vibrant = new Vibrant(img, 64, 5);
			var swatches = vibrant.swatches()
			var color = swatches["Vibrant"].getHex();
			$('#post .post-container p a').css('color', color);
			$('.adaptive-color').css('color', color);
			$('.adaptive-border-color').css('border-color', color);
			$('#post .post-container p u').css('border-color', color);
			$('#post .post-container blockquote').css('border-color', color);
			$('#post code').css('color', color);
			$('#post code').css('background-color', color);
			$('#post code').css('background-color', $('#post code').css('background-color').replace(')', ', 0.15)').replace('rgb', 'rgba'));
			$('#page header .category:first-child').css('background-color', color);
			$('#page #post .category').hover(function(e) {
				$(this).css('background-color', e.type === "mouseenter"?color:"#f6f6f6");
			});
			$('#post .btn.social').hover(function(e) {
				$(this).css('background-color', e.type === "mouseenter"?color:"transparent");
				$(this).css('border-color', e.type === "mouseenter"?color:"#bfbfbf");
			});
			$('#post .aside .author-social a').hover(function(e) {
				$(this).css('background-color', e.type === "mouseenter"?color:"#afafaf");
			});
			
								for (var swatch in swatches)
									if (swatches.hasOwnProperty(swatch) && swatches[swatch])
										console.log(swatch, swatches[swatch].getHex())
		});
	}
	
	// disables off-canvas menu until page loads css to prevent flickering
	$('.pushy').css('display','inline');

	// disables slide animation on mobile navigation
	if($(document).width() > 991) {
		$(window).scroll(function() {
			if(!$('.navbar-search-form').hasClass('active')) {
				minifyNav();
			}
		});

		$('.navbar-search').click(function() {
			showNavSearch();
		});
	}

	// disables scroll to top
	$('.menu-btn').click(function(e){
		e.preventDefault();
	})
	
	// is header transparent on this page?
	//   if so, add background on scroll
	var transparentHeader = false;
	if($('#navigation').hasClass('header')) {
		transparentHeader = true;
	} else {
		$('.texture').addClass('texture-image');
	}
	$(window).scroll(function() {
		if(transparentHeader) {
			if($(window).scrollTop() > 150) {
				$('#navigation').removeClass('header');
			} else {
				$('#navigation').addClass('header');
			}
		}
	});

	// blur background on post page
	$('.texture .image-bg').blurjs({
		source: '#post .img',
		radius: 8
	});
	
	// enable adaptive colors on post page
	adaptiveColors();
	$.stellar();	
});