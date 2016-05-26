$(document).ready(function() {
	$(window).scroll(function () {
		if( $(window).scrollTop() > 50 ) {
			$('#navigation').addClass('nav-dark');
		}
		else {
			$('#navigation').removeClass('nav-dark');
		}
	});
	$('.nav-button').click(function() {
		$('.responsive-nav').slideToggle();
	});
});