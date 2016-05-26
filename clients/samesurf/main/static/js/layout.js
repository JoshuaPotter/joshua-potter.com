$(document).ready(function(){
	
	function getCookie(c_name){
		var c_value = document.cookie;
		var c_start = c_value.indexOf(" " + c_name + "=");
		if (c_start == -1) {
		  c_start = c_value.indexOf(c_name + "=");
		}
		if (c_start == -1){
		  c_value = "MY ACCOUNT";
		}
		else{
		  c_start = c_value.indexOf("=", c_start) + 1;
		  var c_end = c_value.indexOf(";", c_start);
		  if (c_end == -1)
		{
		c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start,c_end));
		}
		return c_value;
	}
	
	var drop_down = false;
	
	$(document).hover(function(e){
		$(".dropdown-nav").hide();
		$(".drop_menu").hide();
	});
	
	$("#site_nav").hover(function(e){
		e.stopPropagation();
		$(".drop_menu").hide();
		$("#header_site_drop").show();
	}, function(e) {
 		e.stopPropagation();
		$("#header_site_drop").hide();
	});
	
	$("#whats_samesurf").hover(function(e){
 		e.stopPropagation();
		$(".dropdown-nav").hide();
		$("#whatssamesurf-dropdown").show();
	}, function(e) {
 		e.stopPropagation();
		$("#whatssamesurf-dropdown").hide();
	});

	$("#uses").hover(function(e){
 		e.stopPropagation();
		$(".dropdown-nav").hide();
		$("#uses-dropdown").show();
	}, function(e) {
		e.stopPropagation();
		$("#uses-dropdown").hide();
	});
	
	$("#header_account").hover(function(e){
 		e.stopPropagation();
		$(".drop_menu").hide();
		$("#header_account_body").show();
	}, function(e) {
 		e.stopPropagation();
		$("#header_account_body").hide();
	});
	
	var name = getCookie("names");
	
	if(name != "MY ACCOUNT"){
		var names = name.split("+");
		var first = names[0];
		var last = names[1];
		var full = first +  " " + last;
		if(full.length > 11){
			full = full.substr(0,10) + "..."
		}
		$("#account_head_text").text(full);
		$(".login_default").hide();
		$(".login_account").show();
	} else {
		$("#account_head_text").text(name);
		$(".login_default").show();
		$(".login_account").hide();
	}
	
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});

	$('.scrollup').click(function () {
		$("html, body").animate({
			scrollTop: 0
		}, 600);
		return false;
	});
	
});