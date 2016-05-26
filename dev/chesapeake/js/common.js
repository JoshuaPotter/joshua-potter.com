jQuery(document).ready(function() {
	"use strict";
	jQuery.noConflict();
	/* slide in menu */
	function sideMenu() {
		if (jQuery('.bars i').hasClass('bars-active')) {
			jQuery('#side-nav .side-nav-wrapper').fadeOut(function() {
				jQuery('#side-nav').animate({
					width: 0,
					minWidth: 0
				});
				jQuery('#side-nav-overlay').fadeOut();
			});
			jQuery('.bars i').removeClass('bars-active');
		} else {
			if(jQuery(window).width() > 991) {
				jQuery('#side-nav').animate({
					width: 'auto',
					minWidth: 300
				}, function() {
					jQuery('#side-nav .side-nav-wrapper').fadeIn();
				});
			} else {
				jQuery('#side-nav').animate({
					width: 'auto',
					minWidth: '85%'
				}, function() {
					jQuery('#side-nav .side-nav-wrapper').fadeIn();
				});
			}
			jQuery('#side-nav-overlay').fadeIn();
			jQuery('.bars i').addClass('bars-active');
		}
	}
	/* slide in menu triggers */
	jQuery('.bars i').click(function() {
		sideMenu();
	});
	jQuery('#side-nav-overlay').click(function() {
		sideMenu();
	});
	jQuery('#close-side-nav').click(function() {
		sideMenu();
	});
	/* slide in menu scroll bar - mCustomScrollbar */
	jQuery('#side-nav').mCustomScrollbar({
		scrollInertia: 0
	});
	/* iframe sizing - FitVids */
	jQuery('.media').fitVids();
	/* filter posts */
	jQuery('.filter-tab').click(function(e) {
		e.preventDefault();
		var postType = jQuery(this).attr('id');
		postType = postType.slice(7);
		jQuery('.posts').attr('id',postType);
		jQuery('.post').fadeOut();
		jQuery('.' + postType).fadeIn();
		jQuery('.filter-tab').removeClass('active');
		jQuery(this).addClass('active');
	});
});