$(document).ready(function() {
	$('.brands-list h4').click(function() {
		var txt = $(".brand-images").is(':visible') ? 'SHOW' : 'HIDE';
		$(".brands-list h4").text(txt);
		$('.brand-images').slideToggle();
	});
});