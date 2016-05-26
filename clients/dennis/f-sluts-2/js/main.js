$(document).ready(function() {
	var $step1 = $('#step1');
	var $step2 = $('#step2');
	var $step3 = $('#step3');
	var $step4 = $('#step4');
	var $r1 = $('.r1');
	var $r2 = $('.r2');
	var $r3 = $('.r3');
	var $r4 = $('.r4');
	var $congrats = $('.congrats');
	var $li1 = $('.li1');
	var $li2 = $('.li2');
	var $li3 = $('.li3');
	var $li4 = $('.li4');
	var $li5 = $('.li5');
	var $loading = $('.loading');

	var $showEnd = $('#showEnd');

	$(document).on('click', '.s1', function(e) {
		$step1.fadeOut(300);
		setTimeout(function() {
			$step2.fadeIn();
		}, 300);
		e.preventDefault();
	});

	$(document).on('click', '.s2', function(e) {
		$step2.fadeOut(300);
		setTimeout(function() {
			$step3.fadeIn();
		}, 300);
		e.preventDefault();
	});

	$(document).on('click', '.s3', function(e) {
		$step3.fadeOut();
		setTimeout(function() {
			$step4.fadeIn();
		}, 300);
		setTimeout(function() {
			$r1.hide();
			$r2.fadeIn();
			$li1.fadeIn();
		}, 1000);
		setTimeout(function() {
			$r2.hide();
			$li1.hide();
			$r3.fadeIn();
			$li2.fadeIn();
			$li3.fadeIn();
		}, 2250);
		setTimeout(function() {
			$r3.hide();
			$r4.fadeIn();
			$li4.fadeIn();
		}, 3000);
		setTimeout(function() {
			$r4.hide();
			$loading.hide();
			$congrats.fadeIn();
			$li5.fadeIn();
			$showEnd.fadeIn();
		}, 4000);
		e.preventDefault();
	});
});
