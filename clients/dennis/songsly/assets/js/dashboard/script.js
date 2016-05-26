/* checkbox toggle */
function checkbox_toggle()
{
    $('a.check-toggle').click(function(e) {
        var clicked = $(this);
        var clicked_input = clicked.attr('href');
        
        if(!$(clicked_input).attr('checked'))
        {
            $(clicked_input).attr('checked', true);
            $(clicked).html('Yes<span>No</span>');
        }
        else
        {
            $(clicked_input).attr('checked', false);
            $(clicked).html('No<span>Yes</span>');
        }
        
        $(clicked).toggleClass('no');
        
        e.preventDefault();
    });
}

/* connected toggle */
function connected_toggle()
{
    $('a[href="#connected"]').hover(function(e) {
        var clicked = $(this);
        
        $(clicked).text($(clicked).text() == 'Connected' ? 'Disconnect' : 'Connected');
        
        e.preventDefault();
    });
}

/* campaign type */
function campaign_type()
{
    $('div.page.settings div.left div.type-of-campaign a').click(function(e) {
        var clicked = $(this);
        var clicked_class = $(this).attr('class').replace(' current', '');
        var current = $('div.page.settings div.left div.type-of-campaign a.current');
        
        current.removeClass('current')
        clicked.addClass('current');
        
        $('input#type_of_campaign').val(clicked_class);
        
        e.preventDefault();
    });
}

/* campaign apply */
function campaign_apply()
{
    $('div.campaign-title a[href="#apply"]').click(function(e) {
        $('h2.campaign-entry, div.campaign-entry').fadeIn(250);
        
        e.preventDefault();
    });
}

/* campaign settings */
function campaign_settings()
{
    $('h2 div.settings').click(function(e) {
        if( $('h2 div.settings ul').is(':hidden'))
        {
            $('h2 div.settings ul').show();
        }
        else
        {
            $('h2 div.settings ul').hide();
        }
        
        e.preventDefault();
    });
}

/* campaign reached last */
function campaign_reaached_last()
{
    $('h2 div.reached-last').click(function(e) {
        console.log('cool');
        if( $('h2 div.reached-last ul').is(':hidden'))
        {
            $('h2 div.reached-last ul').show();
        }
        else
        {
            $('h2 div.reached-last ul').hide();
        }
        
        e.preventDefault();
    });
}

/* campaign overlay */
$(document).ready(function() {
	$('.view').click(function(){
		$('.black-overlay').fadeIn();
		$('.campaign-overlay').show();
		$('.campaign-overlay').animate({
			right: 0
		});
	});
	$('.black-overlay').click(function() {
		$('.black-overlay').fadeOut();
		$('.campaign-overlay').animate({
			right: "-100%"
		}, function() {
			$('.campaign-overlay').hide();
		});
	});
});