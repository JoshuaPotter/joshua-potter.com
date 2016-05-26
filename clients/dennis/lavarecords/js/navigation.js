$(document).ready(function() {
	$(window).scroll(function(){
		
		if ($(window).scrollTop() > 150) {
			$('#header-navigation').addClass('header-small');
		}
		else {
			$('#header-navigation').removeClass('header-small');
		}
	});
	
	$('#roster-nav-list-toggle').click(function() {
		$('#roster-nav-list').slideToggle();
		$('#roster-button').toggleClass('fa-plus');
		$('#roster-button').toggleClass('fa-minus');
	});
});