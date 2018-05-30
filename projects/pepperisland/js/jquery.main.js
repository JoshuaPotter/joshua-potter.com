$(document).ready(function() {
	function pepperIsland() {
		// zoom
		var c = $('#island-container'), im = $('#island-source'), z = $('#zoom');
		var imHeight = $(document).height(),
			imWidth = $(document).width(),
			contWidth = c.width(),
			contHeight = c.height();
		var ratio = Math.min(contWidth / imWidth, contHeight / imHeight);
		imHeight *= ratio;
		imWidth *= ratio;

		// scaling island and departments
		var resizeRatioH, resizeRatioW;
		if($(document).width() > 991) {
			$('#island-source video').css({
				height: imHeight - 80 + 'px'
			});
			resizeRatioH = parseInt($('#island-source video').css("height"))/2304;
			$('#island-source video').css({
				width: resizeRatioH * 4096 +'px' // height ratio * original video size
			});
			resizeRatioW = parseInt($('#island-source video').css("width"))/4096;
		}
		else {
			$('#island-source-mobile').css({
				width: imWidth + 'px'
			});
			resizeRatioW = parseInt($('#island-source-mobile').css("width"))/4096;
			$('#island-source-mobile').css({
				height: resizeRatioW * 2304 +'px' // height ratio * original video size
			});
			$('#island-source').css({
				marginTop: (($(window).height() / 2) - $('#island-source-mobile').height() / 2)
			});
			resizeRatioH = parseInt($('#island-source-mobile').css("height"))/2304;
		}
		$('#island-source').css({
			height: resizeRatioW * 2304 +'px', // height ratio * original video size
			width: resizeRatioH * 4096 +'px' // height ratio * original video size
		});

		// ux & ui
		var dept, deptW, deptH, deptLeft, deptTop, hoverSection;
		function resizeHover(section) {
			dept = $(section);
			dept.removeAttr('style');
			deptW = parseInt(dept.css("width")) * resizeRatioW;
			deptH = parseInt(dept.css("height")) * resizeRatioH;
			deptLeft = dept.position().left * resizeRatioW;
			deptTop = dept.position().top * resizeRatioH;
			dept.css({
				width: deptW,
				height: deptH,
				top: deptTop,
				left: deptLeft
			});
		}
		resizeHover('#island-source .ux-ui');
		resizeHover('#island-source .illustration');
		resizeHover('#island-source .digital-marketing');
		resizeHover('#island-source .app-development');
		resizeHover('#island-source .branding');
		resizeHover('#island-source .web-development');

		var currentScale = 1, currentLocation = {x: 0, y: 0}, mouseLocation = {x: 0, y: 0};
		var minZoom = 1, maxZoom = 1.9125, zoomFactor = 0.15;
		zoom(1);
		var zoomFactorInvertLog = 1 / Math.log(zoomFactor);
		c.on('mousewheel', function(e, delta) {
			var cOffset = c.offset();
			mouseLocation.x = e.pageX - cOffset.left;
			mouseLocation.y = e.pageY - cOffset.top;
			var newZoom = clip(currentScale * (1 + delta * zoomFactor), minZoom, maxZoom);
			var sliderVal = Math.log(newZoom) * zoomFactorInvertLog;
			if(slidInvert) sliderVal = slidMin + slidMax - sliderVal;
			z.slider('value', sliderVal);
			zoom(newZoom);
		});
		function zoom(scale) {
			if(scale <= 1)
			{
				currentLocation.x = (contWidth - imWidth * scale) / 2;
				currentLocation.y = (contHeight - imHeight * scale) / 2;
			}
			else
			{
				var factor = 1 - scale / currentScale;
				currentLocation.x += (mouseLocation.x - currentLocation.x) * factor;
				currentLocation.y += (mouseLocation.y - currentLocation.y) * factor;
				currentLocation.x = clip(currentLocation.x, contWidth - imWidth * scale, 0);
				currentLocation.y = clip(currentLocation.y, contHeight - imHeight * scale, 0);
			}
			var compat = ['-moz-', '-webkit-', '-o-', ''];
			var newCss = {};
			for(var i = compat.length - 1; i; i--)
			{
				newCss[compat[i]+'transform'] = 'translate('+(currentLocation.x)+'px, '+(currentLocation.y)+'px) scale('+scale+')';
			}
			im.css(newCss);
			currentScale = scale;
		}
		function clip(n, m, M) { return n < M ? n > m ? n : m : M; }

		// drag
		var dx;
		var dy;
		var recoupLeft, recoupTop;
		function dragFix(event, ui) {
			dx = ui.position.left - ui.originalPosition.left;
			dy = ui.position.top - ui.originalPosition.top;
			ui.position.left = ui.originalPosition.left + (dx);
			ui.position.top = ui.originalPosition.top + (dy);
			ui.position.left += recoupLeft;
			ui.position.top += recoupTop;

			// top
			if(ui.position.top < -1*(imHeight/2.75)*currentScale) {
				ui.position.top = -1*(imHeight/2.75)*currentScale;
			}
			// bottom
			if(ui.position.top > (imHeight/2.75)*currentScale) {
				ui.position.top = (imHeight/2.75)*currentScale;
			}
			// left
			if(ui.position.left < -1*(imWidth/2.5)*currentScale) {
				ui.position.left = -1*(imWidth/2.5)*currentScale;
			}
			// right
			if(ui.position.left > (imWidth/2.5)*currentScale) {
				ui.position.left = (imWidth/2.5)*currentScale;
			}
		}
		im.draggable({
			drag: dragFix,
			start: function (event, ui) {
				$(this).css('cursor', 'move');
				var left = parseInt( $(this).css('left'), 10 );
				left = isNaN(left) ? 0 : left;
				var top = parseInt( $(this).css('top'), 10 );
				top = isNaN(top) ? 0 : top;
				recoupLeft = left - ui.position.left;
				recoupTop = top - ui.position.top;
			},
			stop: function (event, ui) {
				$(this).css('cursor', 'default');
			}
		});

		// zoom slider
		var slidMin = Math.log(minZoom) * zoomFactorInvertLog, slidMax = Math.log(maxZoom) * zoomFactorInvertLog;
		var slidInvert = (slidMin > slidMax);
		z.slider({
			orientation: 'vertical',
			min: Math.min(slidMin, slidMax),
			max: Math.max(slidMin, slidMax),
			step: Math.abs(slidMin - slidMax) / 20,
			value: slidMin + slidMax
		}).on('slide', function (event, ui) {
			var v = slidInvert ? slidMin + slidMax - ui.value : ui.value;
			var newZoom = Math.pow(zoomFactor, v);
			mouseLocation.x = contWidth / 2;
			mouseLocation.y = contHeight / 2;
			zoom(newZoom);
		});
	}
	pepperIsland();
	if($(document).width() < 991) {
		$('#island-source').panzoom({
			minScale: 1,
			maxScale: 7,
 			increment: 1
		});
	}

	// modal
	var modalID = "#emptyModal";
	$('.modal-close').click(function() {
		$(this).parent().fadeOut(200);
		$('#bg-cover').fadeOut(200);
	});
	$('#bg-cover').click(function() {
		$(this).fadeOut(200);
		$('.modal').fadeOut(200);
	});
	var modalParent;
	var modalDropdown;
	var modalInput;
	$('.modal-call').click(function() {
		modalParent = "#" + $(this).parent().parent().attr("id");
		modalDropdown = modalParent + " .modal-call-dropdown";
		modalInput = modalParent + " input";
		if(!$(modalDropdown).is(':visible')) {
			$(modalDropdown).slideDown(250, function() {
				$(modalParent).css('top', '-=30');
				$(modalInput).fadeIn();
			});
		}
		else {
			$(modalInput).fadeOut(150, function() {
				$(modalParent).css('top', '+=30');
				$(modalDropdown).slideUp(150);
			});
		}
	});
	$('#navigation ul li a').click(function(e) {
		e.preventDefault();
		if(!$(modalID).is(':visible')) {
		modalID = '#' + $(this).attr('class');
		$('#bg-cover').fadeIn(250);
		$(modalID).fadeIn(350);
		} else {
			$(modalID).fadeOut(250);
			modalID = '#' + $(this).attr('class');
			$(modalID).delay(250).fadeIn(350);
		}
	});
	var sectionID;
	$('#navigation ul li a').hover(
		function() {
			sectionID = '#island-source .' + $(this).attr('class');
			$(sectionID).css({opacity: 1});
		}, function() {
			$(sectionID).css({opacity: 0});
		}
	);
	$('#island-source').on('mousedown touchstart', 'section', function(e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		if(!$(modalID).is(':visible')) {
			modalID = '#' + $(this).attr('class');
			$('#bg-cover').fadeIn(250);
			$(modalID).fadeIn(350);
		} else {
			$(modalID).fadeOut(250);
			modalID = '#' + $(this).attr('class');
			$(modalID).delay(250).fadeIn(350);
		}
	});

	// responsive nav
	$('#responsive-btn').click(function() {
		$('#island-navigation-responsive').slideToggle();
	});

	// check if window resized
	// http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed
	var waitForFinalEvent = (function () {
		var timers = {};
		return function (callback, ms, uniqueId) {
			if (!uniqueId) {
				uniqueId = "Don't call this twice without a uniqueId";
			}
			if (timers[uniqueId]) {
				clearTimeout (timers[uniqueId]);
			}
			timers[uniqueId] = setTimeout(callback, ms);
		};
	})();
	$(window).resize(function () {
		waitForFinalEvent(function(){
			pepperIsland();
			if($(window).width() > 991) {
				$('#island-navigation-responsive').hide();
			}
		}, 500, "some unique string");
	});
});
var video = document.querySelector('#island-source-video');
video.addEventListener('loadeddata', function() {
    var preloader = document.querySelector('#preloader');

    function checkLoad() {
        if (video.readyState === 4) {
           $('#preloader').delay(3500).fadeOut(300);
        } else {
            setTimeout(checkLoad, 250);
        }
    }
    checkLoad();
}, false);