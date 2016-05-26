$(document).ready(function() {
	$('.nav-button').bigSlide({
		menuWidth: "75%"
	});

	$('.search i').click(function() {
		$('.search input').toggleClass('opened');
	});
	
	$('#campaign-create-start-date').datepicker();
	$('#campaign-create-end-date').datepicker();
});