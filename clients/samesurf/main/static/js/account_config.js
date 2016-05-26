$(document).ready(function() {
  
	if($(document).find("input").prop("checked")){
		$(".custom_checkbox_tick").css({"display":"inline-block"});
	}

	display_options = function(type){
		
		$(".options_body").hide();
		
		switch(type){
			case"theme":
				$("#theme_body").show();
			break;
			case"main":
				$("#main_body").show();
			break;
			case"premium":
				$("#premium_body").show();
			break;
			case"domains":
				$("#domains_body").show();
			break;
		}
	};
	
	$(".options_tab").on("click", function(){
		var type = $(this).attr('id');
		$(".options_tab").removeClass("options_tab_active");
		$(this).addClass("options_tab_active");
		display_options(type);
	});

	$("#browse_button").on("click", function(){
		$("#logo_upload input").click();
	});
	
	$("input[type=text]").on("keyup", function(){
		$(".color_select").removeClass("color_selected");
		var custom = $("#custom").val();
		if(custom.substr(0,1) == "#"){
			$("#color_custom_foreground").css({"background-color":custom});
		}else{
			$("#button_color").val("rgb("+custom+")");
			$("#color_custom_foreground").css({"background-color":"rgb("+custom+")"});
		}
		$("#color_custom_foreground").addClass("color_selected");
	});
	
	$("input[type=text]").on("click", function(){
		$(this).val("");
		$(this).off("click");
	});
	
	$("input[type=text]").on("keyup", function(){
// 		if($(this).val() < 0){
// 			$(this).val("0");
// 		}else if ($(this).val() > 255){
// 			$(this).val("255");
// 		}
	
		

	});

	$(".about_feature").on("mouseover", function(e){
		var offX = e.offsetX;
		var offY = e.offsetY;
		
		var pageX = e.pageX
		var pageY = e.pageY
		
		var width = $(".info_box").width();
		var height = $(".info_box").height();
		
		var X = pageX - (35) + (22 - offX);
		var Y = pageY + 10 + (22 - offY);
		
		$(".info_box").css({top:Y,left:X});
		$(".info_box").show();	
	});
	
	$(".about_feature").on("mouseout", function(e){
		$(".info_box").hide();	
	});

	$(".custom_checkbox").on("click", function(){
		var checked = $(this).find("input").prop("checked");
		if(checked){
			$(this).find("input").prop("checked",false);
			$(this).find(".custom_checkbox_tick").css({"display":"none"});
		}else{
			$(this).find("input").prop("checked",true);
			$(this).find(".custom_checkbox_tick").css({"display":"inline-block"});
		}
	});
	
	$(".color_select").on("click", function(){
		var id = $(this).attr("id");
		$(".color_select").removeClass("color_selected");
		$("#" + id).addClass("color_selected");
	});
	
	$("#domains_body .existing_domain_remove").on("click", function() {
		$(this).find("form").submit();
	});
	
	$(".existing_domain_wrap").on("mouseover", function(){
		$(this).find(".existing_domain_remove_icon").addClass("existing_domain_remove_icon_hover");
		$(this).find(".existing_domain_manage").removeClass("button_grey");
		$(this).find(".existing_domain_manage").addClass("button_blue");
	});
	
	$(".existing_domain_wrap").on("mouseout", function(){
		$(this).find(".existing_domain_remove_icon").removeClass("existing_domain_remove_icon_hover");
		$(this).find(".existing_domain_manage").addClass("button_grey");
		$(this).find(".existing_domain_manage").removeClass("button_blue");
	});
	
	$(".submit").on("click", function(e) {
		e.preventDefault();
		var form = $("#auth_domain_form");
		$(form).submit();
	});
	
	$(".forward").on("click", function(e) {
		e.preventDefault();
		var form = $("#config_form");
		$(form).submit();
	});

});
