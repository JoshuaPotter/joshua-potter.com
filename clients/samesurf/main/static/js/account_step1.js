$(document).ready(function() {
	$("#adddomain_submit").on("click", function() {
		$("#adddomain form").submit();
	});


	$(".existing_domain_remove").on("click", function() {
		var form = $(this).find("form");
		var remove = confirm("Do you want to delete this Domain? All related domains and users will be delete as well");
		if(remove){
			$(form).submit();
		}
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
	
	$(".existing_domain").on("click", function(){
		$(".existing_domain").removeClass("blue_select");
		$(this).addClass("blue_select");
		var domain = $(this).find(".edit_domain_value").val();
		$("#edit_domain").attr("href",domain);
		
	});
	
	prettyPrint();

});
