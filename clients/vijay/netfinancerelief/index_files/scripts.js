jQuery(document).ready(function($) {
"use strict";


	// Tabs

	//When page loads...
	$('.tabber-contain').each(function() {
		$(this).find(".tabber-content").hide(); //Hide all content
		$(this).find("ul.tabs li:first").addClass("active").show(); //Activate first tab
		$(this).find(".tabber-content:first").show(); //Show first tab content
	});
	
	//On Click Event
	$("ul.tabs li").click(function(e) {
		$(this).parents('.tabber-contain').find("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(this).parents('.tabber-contain').find(".tabber-content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(this).parents('.tabber-contain').find(activeTab).fadeIn(); //Fade in the active ID content
		
		e.preventDefault();
	});
	
	$("ul.tabs li a").click(function(e) {
		e.preventDefault();
	})
	

  	
  	
  	$(window).load(function(){
  	
  	// Sticky Sidebar
	var aboveHeight = $('#head-wrap').outerHeight();
	    $(window).scroll(function(){
	    	if ($(window).scrollTop() > aboveHeight){
	    		$("#sidebar-widget-in").niceScroll({cursorcolor:"#bbb",cursorwidth: 7, cursorborder: 0});
			$("#sidebar-widget-in").getNiceScroll().resize();
	    		$('#sidebar-contain').addClass('side-fixed');
	    	} else {
	    		$('#sidebar-contain').removeClass('side-fixed');
	    	}
		});
		
	// Sticky Social Sharing
	    $(window).scroll(function(){
	    	if ($(window).scrollTop() > aboveHeight){
	    		$('#post-social-wrap').addClass('social-fixed');
	    	} else {
	    		$('#post-social-wrap').removeClass('social-fixed');
	    	}
		});
	
	});
		

	// Mobi nav menu  
	
  	$("#mobile-nav select").change(function() {
	 window.location = $(this).find("option:selected").val();
	});
	
	
	// Social Toggle
	$("#social-nav").click(function(){
	  $("#social-dropdown").slideToggle();
  	});
  	
 	// Search Toggle
 	$("#search-button").click(function(){
 	  $("#search-bar").slideToggle();
  	});
  	
  	// Comments Toggle
  	$(".comment-click").click(function(){
  	  $("#comments").show();
  	  $("#comments-button").hide();
  	});

 	// Mobile Sidebar Toggle
 	$(".mobi-tab-but").click(function(){
 	  $("#sidebar-main-wrap").toggle();
 	  $("#sidebar-main-wrap").niceScroll({cursorcolor:"#bbb",cursorwidth: 7, cursorborder: 0});
  	});
  	
  	$(window).scroll(function(){
 	  if ($(window).width() > 1002){
 	  $('#sidebar-main-wrap').css('display','block');
	    } else { }
 	 });


});