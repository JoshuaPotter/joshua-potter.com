$(document).ready(function() {
	// allows use of button outside of form tags
	$("#save-changes").click(function() {
		$("#profile-settings").submit();
	});
	// clear placeholder on click 
	$("input").click(function(){
		$(this).val("");
	});
	$("textarea").click(function(){
		$(this).val("");
	});
});