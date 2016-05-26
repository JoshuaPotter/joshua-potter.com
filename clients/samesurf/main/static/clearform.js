$(document).ready(function(){
	$("#domain input").on("focus",function() {
	    var contents =$("#domain input").val();
	    if (contents == "e.g. www.samesurf.com") {
			$("#domain input").val("");
		}
	});	
	
	$("#domain input").on("blur",function() {
		var contents = $("#domain input").val();
		if (contents == "") {
			$("#domain input").val("e.g. www.samesurf.com");
		}
		
		if (contents != "") {
			$("#domain .tick").css("display","inline-block");
		}
		else {
			$("#domain .tick").css("display","none");
		}
	});	
	
	$("#email input").on("focus",function() {
		var contents =$("#email input").val();
		if (contents == "e.g. john@email.com") {
			$("#email input").val("");
		}
	});	
	
	$("#email input").on("blur",function() {
		var contents =$("#email input").val();
		if (contents == "") {
			$("#email input").val("e.g. john@email.com");
		}
		if (contents != "" && contents.search("@") > 0) {
			$("#email .tick").css("display","inline-block");
		}
		else {
			$("#email .tick").css("display","none");
		}
	});	
	
	$("#firstname input").on("blur",function() {
		var contents =$("#firstname input").val();
		if (contents != "") {
			$("#firstname .tick").css("display","inline-block");
		}
		else {
			$("#firstname .tick").css("display","none");
		}
	});	
	
	$("#lastname input").on("blur",function() {
		var contents =$("#lastname input").val();
		if (contents != "") {
			$("#lastname .tick").css("display","inline-block");
		}
		if (contents != "") {
			$("#lastname .tick").css("display","inline-block");
		}
		else {
			$("#lastname .tick").css("display","none");
		}
	});	
	
	$(".nextstep").on("click",function()	{
		var ischecked =$("#domainownercheckbox").prop("checked");
		if (ischecked ==false)	{
			$("#domainownererror span").show();
			}
	});	
	
	$(".nextstep").on("click",function()	{
		var ischecked =$("#usesamesurfcheckbox").prop("checked");
		var ischecked2 =$("#usesamesurfcheckbox2").prop("checked");
		if (ischecked == false && ischecked2 == false)	{
			$("#usesamesurferror span").show();
			}
		else {
			var firstname =$("#firstname input").val();
			var lastname =$("#lastname input").val();
			var domain =$("#domain input").val();
			var email =$("#email input").val();
			}	
	});	
	
	$("#password input").on("blur",function()	{
	var password =$("#password input").val();
	if (contents != "") {
			$("#password .tick").css("display","inline-block");
		}
		else {
			$("#password .tick").css("display","none");
		}
	});
	
	$("#confirmpassword input").on("blur",function()	{
	var confirmpassword =$("#confirmpassword input").val();
	if (contents != "") {
			$("#confirmpassword .tick").css("display","inline-block");
		}
		else {
			$("#confirmpassword .tick").css("display","none");
		}
	
	});
});