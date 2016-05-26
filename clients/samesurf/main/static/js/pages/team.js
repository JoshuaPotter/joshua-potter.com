// wait until the page is ready and do this
$(document).ready(function() {

	// add a click handler to all the contentbox
	$('.contentbox').on('click', function() {

		// get the height of the contentboxtext of the clicked contentbox
		var textheight = $(this).find('.contentboxtext').height();
		// 10px added for padding at bottom of expanded box
		textheight += 10;

		// initially none of the contentbox will have an expanded attribute
		// this is equivalent to it being false

		if (this.expanded == true) {
			$(this).animate({
				height: "-=" + textheight,
			});
			this.expanded = false;
		}
		else {
			$(this).animate({
				height: "+=" + textheight,
			});
			this.expanded = true;
		}

		// find the downarrow on the clicked contentbox
		// add or remove the inverted class which rotates by 180 degrees

		$(this).find('.downarrow').toggleClass('inverted');


	});

});
