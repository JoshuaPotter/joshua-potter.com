/* home page scroll */
function home_scroll()
{
    // div#header ul.navigation - added ability for footer links now
    $('a.local').click(function(e) {
        var scrollFrom = $('div#header ul.navigation li a.current');
        var clicked = $(this);
        var scrollTo = $(this).attr('href').replace('#', '');
        
        $('html, body').animate({
            scrollTop: $('div#features ul li#' + scrollTo).offset().top-78
        }, 750, function() {
            scrollFrom.removeClass('current');
            clicked.addClass('current');
        });
        
        e.preventDefault();
    });
}

/* home navigation change */
function home_nav()
{
    var bodyTop = $(document).scrollTop();
    var scrollFrom = $('div#header ul.navigation li a.current');
    var whySongsly = $('div#features ul li#why-songsly').offset().top-78;
    var howItWorks = $('div#features ul li#how-it-works').offset().top-78;
    var anotherFeature = $('div#features ul li#another-feature').offset().top-78;
    var anotherFeature2 = $('div#features ul li#another-feature2').offset().top-78;
    var tryIt = $('div#try-it').offset().top-78;
    
    // check if at top, display slogan. if scroll moves down, display nav.
    if(bodyTop == '0' || bodyTop < '0') {
        if(!$('div#header div.slogan').is(':animated')) {
            $('div#header ul.navigation').fadeOut(250, function() {
                $('div#header div.slogan').fadeIn(250);
            });
        }
    }
    else
    {
        if(!$('div#header ul.navigation').is(':animated')) {
            $('div#header div.slogan').fadeOut(250, function() {
                $('div#header ul.navigation').fadeIn(250);
            });
        }
    }
    
    // remove previous anchor class
    scrollFrom.removeClass('current');
    
    // check if scrolling to element and add class
    if(bodyTop >= whySongsly && bodyTop < howItWorks)
    {
        $('div#header ul.navigation li a[href="#why-songsly"]').addClass('current');
    }
    
    if(bodyTop >= howItWorks && bodyTop < anotherFeature)
    {
        $('div#header ul.navigation li a[href="#how-it-works"]').addClass('current');
    }
    
    if(bodyTop >= anotherFeature && bodyTop < anotherFeature2)
    {
        $('div#header ul.navigation li a[href="#another-feature"]').addClass('current');
    }
    
    if(bodyTop >= anotherFeature2 && bodyTop < tryIt)
    {
        $('div#header ul.navigation li a[href="#another-feature2"]').addClass('current');
    }
}

/* home lightbox (login) */
function home_lightbox()
{
    var popupStatus = 0;

    function loadPopup(popupBackground, dialogToLoad)
    {
    	if(popupStatus == 0)
        {
            if(popupBackground == 1)
            {
                $('div#lightbox-background').css({
                    'opacity': '0.8'
                });
                $('div#lightbox-background').fadeIn(300);
                $('body').addClass('lightbox');
                $('body').bind('touchmove', function(e){e.preventDefault()}) // no scroll mobile
            }
    		
    		$('div#' + dialogToLoad + 'Lightbox.lightbox').fadeIn(300);
            
    		popupStatus = 1;
    	}
    }

    function disablePopup(popupBackground)
    {
    	if(popupStatus == 1)
        {
    		if(popupBackground == 1) { $('div#lightbox-background').fadeOut(300); }
            
    		$('div.lightbox').fadeOut(300);
            $('body').removeClass('lightbox');
            $('body').unbind('touchmove'); // no scroll  mobile unbind
            
    		popupStatus = 0;
    	}
    }
    
    function centerPopup()
    {
    	var windowWidth = document.documentElement.clientWidth;
    	var windowHeight = document.documentElement.clientHeight;
    	var popupHeight = $('div.lightbox').height();
    	var popupWidth = $('div.lightbox').width();
        
    	$('div.lightbox').css({
   		   'position': 'absolute',
    		'top': windowHeight/2-popupHeight/2,
    		'left': windowWidth/2-popupWidth/2
    	});
    	
    	$('div#lightbox-background').css({
    		'height': windowHeight
    	});
    	
    }
    
    $('a.login').click(function()
    {
        var dialogToLoad = $(this).attr('class').replace(/^(\S*).*/, '$1');
        
		centerPopup(1);
		loadPopup(1, dialogToLoad);
        
        return false;
	});
    
    $('a.lightbox-inner').click(function()
    {
        var dialogToLoad = $(this).attr('class').replace(/^(\S*).*/, '$1');
        
        disablePopup(0);
        centerPopup();
		loadPopup(0, dialogToLoad);
        
        return false;
	});
    
    $('a.lightbox-close').click(function()
    {
		disablePopup(1);
        
        return false;
	});
    
    $('div#lightbox-background').click(function()
    {
		disablePopup(1);
	});
}

/* user notifications */
function user_notifications()
{
    $('a.user-notifications').click(function(e) {
        if( $('div.user div.notifications').is(':hidden'))
        {
            $('div.user div.notifications').show();
        }
        else
        {
            $('div.user div.notifications').hide();
        }
        
        e.preventDefault();
    });
}

/* mobile navigation */
function mobile_navigation()
{
    $('div.mobile-navigation a').click(function(e) {
        $('ul.mobile-navigation').slideToggle(250);
        
        e.preventDefault();
    });
}