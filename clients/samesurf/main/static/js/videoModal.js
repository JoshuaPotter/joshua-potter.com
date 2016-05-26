function modalVideo_id(id){
	switch(id){
		case "Homepage_video":
			var supplier = "vimeo";
			var vid_id = 53180842;
			break;
		case "videos_video1":
			var supplier = "vimeo";
			var vid_id = 53180842;
			break;
		case "videos_video1":
			var supplier = "vimeo";
			var vid_id = 53180842;
			break;
	}
	switch(supplier){
		case "vimeo":
			$(".player_frame iframe").remove();
			var playerVimeo = '<iframe type="text/html" width="736" height="440" id="player1" src="http://player.vimeo.com/video/'+vid_id+'?api=1&amp;player_id=player1" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>';
			$('.player-container').html(playerVimeo);
			break;
		case "youtube":
			var videoIframe = '<iframe id="videoplayer" width="960" height="538" src="http://www.youtube.com/embed/'+vid_id+'?rel=0&autoplay=1" ></iframe>';
			$('.player-container').html(videoIframe);
			break;
	};
}
$(document).ready(function(){

	//select all the a tag with name equal to modal
	$('.modal').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
		
		var id = $(this).attr("id");
	
		modalVideo_id(id);
		
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(250);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
		
		var scroll_Y = $(window).scrollTop();
			  
		//Set the popup window to center
		$('#modal_video').css('top',  (winH/2-$('#modal_video').height()/2)+scroll_Y);
		$('#modal_video').css('left', winW/2-$('#modal_video').width()/2);
	
		//transition effect
		$('#modal_video').fadeIn(500); 
		
		/*samesurf_data_api_ready.isready(function() {
			send_if_leader("start_video", id);
		});*/
	
	});
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		//clearInterval(self.video_man._video_player.PlayerInterval);
		$(".player_frame iframe").remove();
		$('#mask').hide();
		$('.window').hide();
		/*samesurf_data_api_ready.isready(function() {
			send_if_leader("close", "");
		});*/
	});		
	
	//if mask is clicked
	$('#mask').click(function (e) {
		e.preventDefault();
		//clearInterval(self.video_man._video_player.PlayerInterval);
		$(".player_frame iframe").remove();
		$('#mask').hide();
		$('.window').hide();
		/*samesurf_data_api_ready.isready(function() {
			send_if_leader("close", "");
		});*/
	});			
});
/*samesurf_data_api_ready.isready(function() {
	$(document).ready(function(){
		samesurf_data_api.registerDataType("start_video", function(name, data){ 
			setTimeout(function(){
				modalVideo_id(data);
				var maskHeight = $(document).height();
				var maskWidth = $(window).width();
	
				$('#mask').css({'width':maskWidth,'height':maskHeight});
					
				$('#mask').fadeIn(250);	
				$('#mask').fadeTo("slow",0.8);	
				
				var winH = $(window).height();
				var winW = $(window).width();
				var scroll_Y = $(window).scrollTop();
								 
				$("#modal_video").css('top',  (winH/2-$('#modal_video').height()/2)+scroll_Y);
				$("#modal_video").css('left', winW/2-$("#modal_video").width()/2);
				
				$("#modal_video").fadeIn(500); 
				},1000);
		});
	
		samesurf_data_api.registerDataType("close", function(name, data) {
			clearInterval(self.video_man._video_player.PlayerInterval); 
			$(".player_frame iframe").remove();
			$('#mask').hide();
			$('.window').hide();
		});
	});
});*/