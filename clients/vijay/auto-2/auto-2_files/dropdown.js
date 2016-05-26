$(function() {

    var $sliding = [];

    // Drop downs
    
    $(".dropdown").each(function($idx){

        $(this).find('.dropdown span').html($(this).find(' li:first-of-type').text());

        $(this).click(function(){

            var $span = $(this).find('span');

            if ( $sliding [ $idx ] )
                return false;

            var $ul = $(this).find("ul");
            var $drop = $(this).find(".dropdown");
            
            $span.toggleClass("up");     
            $sliding [ $idx ] = true;

            $(this).find('li a').click(function(){
                var $text = $(this).text();
                $span.html($text);
            });

             $drop.toggleClass("down");
             
            $ul.slideToggle("500", function(){
                $sliding [ $idx ] = false;
            });
                
        });
    });
	
	var down = false;
	$('.nav-dropdown').click(function() {
		if(down == false) {
			down = true;
			$('.mobile').slideDown();
		} else {
			down = false;
			$('.mobile').slideUp();
		}
			
	});
	
});