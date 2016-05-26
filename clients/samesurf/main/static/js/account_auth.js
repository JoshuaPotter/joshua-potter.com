$(document).ready(function() {

	$("#add_domain .submit").on("click", function() {
		var form = this.previousElementSibling;
		$(form).submit();
	});

	$("#add_user .submit").on("click", function() {
		var form = this.previousElementSibling;
		$(form).submit();
	});

	$("#add_domain .existing_domain_remove").on("click", function() {
		$(this).find("form").submit();
	});

	$("#add_user .existing_domain_remove").on("click", function() {
		$(this).find("form").submit();
	});

	$(".existing li").on("mouseover", function(){
		$(this).find(".entry_dismiss").show();
	});
	
	$(".existing li").on("mousein", function(){
		$(this).find(".entry_dismiss").show();
	});
	
	$(".existing li").on("mouseout", function(){
		$(this).find(".entry_dismiss").hide();
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

});
