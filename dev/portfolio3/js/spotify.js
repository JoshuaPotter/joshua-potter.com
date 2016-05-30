function spotifyJs(user, key, spotifyUser, animations) {
	var progress,
		audioObject = null;
	var interval = 15000;
	var clientId = "";
	var layout = '<div id="cover">\
									<div class="row">\
										<a class="album">\
											<img src="" id="album-cover" alt="Album cover" class="img-responsive" crossOrigin="">\
											<div class="record">\
											<div class="eye"></div>\
											  <svg class="disc" width="150px" height="150px" viewBox="0 0 150 150" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">\
												<defs></defs>\
												<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">\
													<g id="Group" sketch:type="MSLayerGroup" transform="translate(75.000000, 75.000000) scale(1, -1) translate(-75.000000, -75.000000) ">\
														<path d="M75,150 C116.421356,150 150,116.421356 150,75 C150,33.5786438 116.421356,0 75,0 C33.5786438,0 0,33.5786438 0,75 C0,116.421356 33.5786438,150 75,150 Z" id="Oval-1" fill="#312F2D" sketch:type="MSShapeGroup"></path>\
														<path d="M27.7421875,75 C27.7421875,101.017578 51.7402344,122.183594 75,122.183594" id="Path-1" stroke="#5A5A5A" stroke-width="2" stroke-linecap="round" sketch:type="MSShapeGroup"></path>\
														<path d="M75,38.1484375 C75,58.4688144 93.4978363,75 111.426601,75" id="Path-1-Copy-3" stroke="#5A5A5A" stroke-width="2" stroke-linecap="round" sketch:type="MSShapeGroup" transform="translate(93.213301, 56.574219) scale(-1, -1) translate(-93.213301, -56.574219) "></path>\
														<path d="M38.0904708,75 C38.0904708,95.3203769 56.8335434,111.851562 75,111.851562" id="Path-1-Copy" stroke="#5A5A5A" stroke-width="2" stroke-linecap="round" sketch:type="MSShapeGroup"></path>\
														<path d="M75,27.8164062 C75,53.8339844 98.9980469,75 122.257812,75" id="Path-1-Copy-4" stroke="#5A5A5A" stroke-width="2" stroke-linecap="round" sketch:type="MSShapeGroup" transform="translate(98.628906, 51.408203) scale(-1, -1) translate(-98.628906, -51.408203) "></path>\
													</g>\
												</g>\
											</svg>\
											</div>\
										</a>\
										<div class="progress">\
											<div class="active"></div>\
										</div>\
										<div class="col-md-3 valign">\
											<div class="animation">\
												<div class="waveform"></div>\
												<div class="waveform"></div>\
												<div class="waveform"></div>\
												<div class="waveform"></div>\
											</div>\
										</div>\
										<div class="col-md-7 col-sm-offset-1 valign">\
											<div class="song">\
												<div class="track"></div>\
												<div class="artist"></div>\
											</div>\
										</div>\
									</div>\
								</div><a href="https://open.spotify.com/user/' + spotifyUser + '" target="_blank" id="feed" title="Follow me on Spotify">\
									<span>I"m currently listening to </span>\
									<strong></strong><span class="track"></span><strong></strong> \
									<span>by</span>\
									<span class="artist"></span>\
									<span>on</span>\
									<i class="fa fa-spotify fa-2x" aria-hidden="true"></i>\
									<span class="spotify">Spotify</span>\
								</a>';
	$('#spotifyJs').html(layout);

	function run() {
		$.ajax({
				url: "http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=" + user + "&api_key=" + key + "&limit=1&format=json",
				type: "GET",
				dataType: "json",
			})
			.always(function() {
				console.log('Checking Last.fm for updates');
			})
			.done(function(json) {
				//console.log(json);
				// if currently listening, search spotify for track details with last.fm response
				//   and update music card with metadata
				try {
					if (json.recenttracks.track[0]["@attr"].nowplaying) {
						if (json.recenttracks.track[0].name.toLowerCase() !== $('#spotifyJs #feed .track').text().toLowerCase()) {
							$('#spotifyJs').addClass('active');
							console.log('Update received from  Last.fm');
							// get spotify metadata based on last.fm track info
							$.ajax({
									url: "https://api.spotify.com/v1/search?q=" + "track:" + encodeURIComponent(json.recenttracks.track[0].name) + " artist:" + encodeURIComponent(json.recenttracks.track[0].artist['#text']) + " album:" + encodeURIComponent(json.recenttracks.track[0].album['#text']) + "&type=track&limit=1",
									type: "GET",
									dataType: "json",
								})
								.always(function() {
									console.log('Getting metadata from Spotify');

									// reset timestamp
									clearInterval(progress);
									$('#spotifyJs #cover .progress .active').animate({
										'width': $('#spotifyJs #cover').width() * 0.01
									}, 10);
								})
								.done(function(json) {
									console.log(json);
									// format and update artist names
									var artistLinks = "";
									var artists = "";
									if (json.tracks.items[0].artists.length > 1) {
										$.each(json.tracks.items[0].artists, function(i, v) {
											artists += json.tracks.items[0].artists[i].name + ", ";
											artistLinks += "<a href='" + json.tracks.items[0].artists[i].uri + "'>" + json.tracks.items[0].artists[i].name + "</a>, ";
											$('#spotifyJs #cover .artist').attr("data-artist-" + i + "-id", json.tracks.items[0].artists[i].id);
										});
									} else {
										artists = json.tracks.items[0].artists[0].name;
										artistLinks = "<a href='" + json.tracks.items[0].artists[0].uri + "'>" + json.tracks.items[0].artists[0].name + "</a>";
										$('#spotifyJs #cover .artist').attr("data-artist-0-id", json.tracks.items[0].artists[0].id);
									}
									// peel off trailing comma
									if (json.tracks.items[0].artists.length > 1) {
										artists = artists.slice(0, -2);
										artistLinks = artistLinks.slice(0, -2);
									}
									$('#spotifyJs #cover .artist').html(artistLinks);
									$('#spotifyJs #feed .artist').html(json.tracks.items[0].artists[0].name);

									// format and update track name
									if (json.tracks.items[0].name.length > 27) {
										var str = json.tracks.items[0].name.substring(0, 24) + "...";
										$('#spotifyJs #cover .track').html("<a href='" + json.tracks.items[0].uri + "'>" + str + "</a>");
										$('#spotifyJs #feed .track').html(json.tracks.items[0].name);
									} else {
										$('#spotifyJs #cover .track').html("<a href='" + json.tracks.items[0].uri + "'>" + json.tracks.items[0].name + "</a>");
										$('#spotifyJs #feed .track').html(json.tracks.items[0].name);
									}
									$('#spotifyJs #cover .track').attr('data-track-id', json.tracks.items[0].id);

									// update album cover
									if (json.tracks.items[0].album.images[1].url.length > 0) {
										$('#cover .album').attr('href', json.tracks.items[0].preview_url).attr("data-album-id", json.tracks.items[0].album.id);
										$('#cover .album img').attr('src', json.tracks.items[0].album.images[1].url).attr('title', json.tracks.items[0].album.name);
									}

									// update waveform colors based on new album cover
									$('#album-cover').on('load', function() {
										var sourceImage = document.getElementById("album-cover");
										var colorThief = new ColorThief();
										var color = colorThief.getPalette(sourceImage, 4);
										$('#spotifyJs #cover .progress .active').css("background", "rgb(" + color[3] + ")");
										$('.waveform:nth-of-type(1)').css("background", "rgb(" + color[3] + ")");
										$('.waveform:nth-of-type(2)').css("background", "rgb(" + color[1] + ")");
										$('.waveform:nth-of-type(3)').css("background", "rgb(" + color[0] + ")");
										$('.waveform:nth-of-type(4)').css("background", "rgb(" + color[2] + ")");
										//$('#spotifyJs .album .record #Oval-1').css("fill", "rgb(" + color[1] + ")");
										$('#spotifyJs .album .record .eye').css("background", "rgb(" + color[3] + ")");
									});

									// start timestamp
									// this is only an estimate, as last.fm and spotify do not 
									//   provide access to how much of a track you have listened to
									// adds ~1% in timestamp progress every 1% of the song listened to
									//   but is entirely dependent upon update rate of the api, causing
									//   up to 15 seconds delay initially
									var duration = json.tracks.items[0].duration_ms;
									var progressInterval = (duration * 0.015); // find equivalent of 1% of duration in milliseconds
									var listenedTo = ($('#spotifyJs #cover').width() * 0.015);
									progress = setInterval(function() {
										$('#spotifyJs #cover .progress .active').animate({
											'width': "+=" + listenedTo
										}, (progressInterval / 2), "linear");
									}, progressInterval);
								
									if(animations === true) {
										$.ajax({
											//https://github.com/jwilsson/spotify-web-api-php
											url: "./auth/spotifyjs.php?id=" + $('#spotifyJs .track').attr('data-track-id'),
											type: "GET",
											dataType: "json"
										})
										.always(function() {
											console.log('Getting audio features from Spotify');
											
										})
										.done(function(json) {
											console.log(json);
										});
									}
								});
						}
					}
					if ($('#spotifyJs').hasClass('active')) {
						interval = 15000;
					} else {
						interval = 60000;
					}
				} catch (e) {
					clearInterval(progress);
					$('#spotifyJs').removeClass('active');
				}
			});
	}
	run();
	setInterval(function() {
		run();
	}, interval);
	$('#spotifyJs #cover .album').click(function(e) {
		e.preventDefault();
		var parent = $('#spotifyJs');
		var target = $(this);
		if (target !== null) {
			if (parent.hasClass('playing')) {
				audioObject.pause();
			} else {
				if (audioObject) {
					audioObject.pause();
				}
				audioObject = new Audio(target.attr('href'));
				audioObject.play();
				parent.addClass('playing');
				audioObject.addEventListener('ended', function() {
					parent.removeClass('playing');
				});
				audioObject.addEventListener('pause', function() {
					parent.removeClass('playing');
				});
			}
		}
	});
}