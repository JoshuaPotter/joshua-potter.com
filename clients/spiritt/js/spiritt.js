$(document).ready(function() {
	$('.attachment-handler').click(function(e) {
		e.preventDefault();
		$("#attachment").trigger('click');
	})
	$("#attachment").change(function(e) {
		e.preventDefault();
		$('.attachment-label').text(this.value.replace(/C:\\fakepath\\/i, ''))
	}) 
	$('#header .navigation .responsive a').click(function(e) {
		e.preventDefault();
		$('#responsive-nav').slideToggle();
	});
});
  $(window).load(function() {
    $('.flexslider').flexslider({
		smoothHeight: true,
		pauseOnAction: false
	});
  });