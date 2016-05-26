$(document).ready(function() {

	var slide_number = 1;

	setInterval(function() {

		var current = slide_number;
		var next = current + 1;

		if (next == 5) {
			next = 1;
		}
		slide_number = next;

		$('#sliding_banner_container').css({
			backgroundImage: $('#slide' + current).css('background-image')
		});

		$('#slide' + current).fadeOut(600, function() {
			$('#slide' + next).fadeIn().css('display', 'table');
		});

		$('#banner_button' + current).fadeOut(600, function() {
			$('#banner_button' + next).fadeIn();
		});

	}, 7000);

	$("#sapientpage, #livepersonpage").hide();
	$("#liveperson_logo").hover(function() {
		$("#samesurfpage, #sapientpage").fadeOut(function() {
			$("#livepersonpage").fadeIn();
		});
		$(".logo").removeClass("selectedlogo");
		$(this.parentNode).addClass("selectedlogo");
	});

	$("#samesurf_logo").hover(function() {
		$("#livepersonpage, #sapientpage").fadeOut(function() {
			$("#samesurfpage").fadeIn();
		});
		$(".logo").removeClass("selectedlogo");
		$(this.parentNode).addClass("selectedlogo");
	});

	$("#sapient_logo").hover(function() {
		$("#samesurfpage, #livepersonpage").fadeOut(function() {
			$("#sapientpage").fadeIn();
		});
		$(".logo").removeClass("selectedlogo");
		$(this.parentNode).addClass("selectedlogo");
	});

});