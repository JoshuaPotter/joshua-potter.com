$(document).ready(function() {

	$("#formtextarea").on("focus", function() {
		$("#formtextarea").val("");
	
	});
	
	$("#nametext").on("focus", function() {
		$("#nametext").val("");
	
	});
	
	$("#emailtext").on("focus", function() {
		$("#emailtext").val("");
	
	});
	
	$("#titletext").on("focus", function() {
		$("#titletext").val("");
	
	});
	
	$("#phonetext").on("focus", function() {
		$("#phonetext").val("");
	
	});
	
	$("#companytext").on("focus", function() {
		$("#companytext").val("");
	
	});
	
	$("#formtextarea").on("focus", function() {
		$("#formtextarea").val("");
	
	});
	
	$("#nametext").on("blur", function() {
		var title = $("#nametext").val();
		if (title == ""){
			$("#nametext").val("Name");
		}
	
	});
	
	$("#emailtext").on("blur", function() {
		var title = $("#emailtext").val();
		if (title == ""){
			$("#emailtext").val("Email Address");
		}
	
	});
	
	$("#titletext").on("blur", function() {
		var title = $("#titletext").val();
		if (title == ""){
			$("#titletext").val("Title");
		}
	
	});
	
	$("#phonetext").on("blur", function() {
		var title = $("#phonetext").val();
		if (title == ""){
			$("#phonetext").val("Phone");
		}
	
	});
	
	$("#companytext").on("blur", function() {
		var title = $("#companytext").val();
		if (title == ""){
			$("#companytext").val("Company");
		}
	
	});
	
	$("#formtextarea").on("blur", function() {
		var title = $("#formtextarea").val();
		if (title == ""){
			$("#formtextarea").val("e.g. Work Collaboration");
		}
	
	});

	$("#formsubmit").on("click", function() {
		$("form").submit();
		
		
	});

})