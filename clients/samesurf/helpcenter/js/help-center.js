$(document).ready(function() {
	$('.posts article .heading').click(function() {
		$(this).parent().find('.body:first').slideToggle(250);
		$(this).parent().find('.toggle i:first').toggleClass('fa-rotate-180');
	});
	/*
	$('.tabs li').click(function() {
		$('.tabs li').removeClass('active');
		$(this).addClass('active');
		if($(this).attr('id') == 'desktop-tab') {
			$('#presentation-articles').hide();
			$('#mobile-articles').hide();
			$('#desktop-articles').show();
		}
		else if($(this).attr('id') == 'mobile-tab') {
			$('#presentation-articles').hide();
			$('#desktop-articles').hide();
			$('#mobile-articles').show();
		}
		else {
			$('#desktop-articles').hide();
			$('#mobile-articles').hide();
			$('#presentation-articles').show();
		}
	});*/
	$('.articles-container').hide();

    // if hash present, show requested tab
    if(document.location.hash!='') {
        showTabByHash();
    }
    else {
        showFirstTab();
    }

    $('.tabs li').click(function (e) {
        e.preventDefault();
		var tabTitle = $(this).attr('id');
		var tabLi = '#' + $(this).attr('id');
		tabTitle = tabTitle.substring(0, tabTitle.length - 3);
		tabTitle = '#' + tabTitle + 'articles';
        showTab(tabTitle, tabLi);
    });
	
	function showTab(tabTitle, tabLi) {
		// active class for tab
		$('.tabs li').removeClass('active');
		$(tabLi).addClass('active');
		window.location.hash = tabLi.substring(0, tabLi.length - 4);

		// show content for corresponding tab
		$('.articles-container').hide();
		$(tabTitle).show();
	}

	function showTabByHash() {
		var tabLi = window.location.hash;
		var tabTitle = window.location.hash;
		
		// show content for corresponding tab
		tabLi = tabLi + '-tab';
		tabTitle = tabTitle + '-articles';
		showTab(tabTitle, tabLi);
	}

	function showFirstTab() {
		// show first tab
		var firstTab = $('.tabs .active').attr('id');
		window.location.hash = firstTab.substring(0, firstTab.length - 4);
		firstTab = firstTab.substring(0, firstTab.length - 3);
		firstTab = '#' + firstTab + 'articles';
		$(firstTab).show();
	}
});