$(document).ready(function() {
	
	$('.nav-button').click(function() {
		$('.navigation ul').slideToggle();
	});

	switch (window.location.pathname) {
		case '/index.php':
			$('.nav-link-home').addClass('active');
			break;
		case '/mortgage-refinance.php':
			$('.nav-link-mortgage').addClass('active');
			break;
		case '/mortgage.php':
			$('.nav-link-mortgage').addClass('active');
			break;
	}
	
	$('#map').usmap({
		stateStyles: {
			fill: '#5099BA',
			stroke: '#ffffff'
		},
		stateHoverStyles: {
			fill: '#468099'
		},
		showLabels: true,
		// The click action
		click: function() {
			window.open('../refinance.php');
		}
	});
});