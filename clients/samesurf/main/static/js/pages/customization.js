$(document).ready(function() {

	$("#button1").hover(function() {
		$("#content1image2, #content1image3").fadeOut(150, function() {
			$("#content1image1").fadeIn();
		});
	});

	$("#button2").hover(function() {
		$("#content1image1, #content1image3").fadeOut(150, function() {
			$("#content1image2").fadeIn();
		});
	});

	$("#button3").hover(function() {
		$("#content1image1, #content1image2").fadeOut(150, function() {
			$("#content1image3").fadeIn();
		});
	});

});