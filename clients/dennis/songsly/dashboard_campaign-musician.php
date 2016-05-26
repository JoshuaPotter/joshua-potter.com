<?php require 'dashboard_header.php'; ?>
            <div class="left">
                <h2 title="Campaign Title by Musician">
                    Campaign Title by Musician
                    <div class="settings">
                        <ul>
                            <li><a href="#edit-info" title="Edit info">Edit info</a></li>
                            <li><a href="#increase-budget" title="Increase budget">Increase budget</a></li>
                            <li><a href="#end-campaign" title="End campaign">End campaign</a></li>
                            <li><a href="#delete-campaign" title="Delete campaign">Delete campaign</a></li>
                        </ul>
                    </div>
                </h2>
                <div class="campaign-title block">
                    <div class="photo">
                        <img src="<?php echo WWW; ?>assets/images/dashboard/campaign-cover.jpg" alt="Campaign Title" />
                    </div>
					<div class="campaign-stats">
						<div class="first-row">
							<span class="current-balance first-child">
								Reached Today
								<span class="number">12,530</span>
							</span>
							<span class="last-month first-child">
								All Time Reach
								<span class="number">54,389</span>
							</span>
						</div>
						<span class="current-balance">
							Remaining Budget
							<span class="number">$4,389</span>
						</span>
						<span class="last-month">
							Allocated Budget
							<span class="number">$59,521</span>
						</span>
					</div>
					<div class="campaign-alt-stats">
						<div class="row">
							<span class="left pays">Pays</span>
							<span class="right pays">$59</span>
						</div>
						<div class="row">
							<span class="left">Popularity</span>
							<span class="right stars"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><span class="gray"><i class="fa fa-star"></i><i class="fa fa-star"></i></span></span>
						</div>
						<div class="row">
							<span class="left">Genre</span>
							<span class="right"><a href="#rock" title="rock">rock</a>, <a href="#metal" title="metal">metal</a>, <a href="#alternative" title="alternative">alternative</a></span>
						</div>
						<div class="row">
							<span class="left">Type</span>
							<span class="right">Public</span>
						</div>
					</div>
					<div class="campaign-permalink">
						<form>
							<input type="text" value="http://sng.ly/1x32g" />
						</form>
					</div>
					<div class="campaign-social">
						<a href="#"><i class="fa fa-twitter fa-lg"></i></a>
						<a href="#"><i class="fa fa-facebook fa-lg"></i></a>
					</div>
                </div>
            </div>
            <div class="right">
                <h2 title="Campaign Details for Campaign Title">Campaign Details for Campaign Title</h2>
                <div class="campaign-details block">
                    <div class="photo">
                        <img src="<?php echo WWW; ?>assets/images/dashboard/campaign-bieber.jpg" alt="Campaign YouTuber" />
                        <a class="social-network twitter" href="#twitter" title="Twitter">Twitter</a>
                        <a class="social-network facebook" href="#facebook" title="Facebook">Facebook</a>
                        <a class="social-network youtube" href="#youtube" title="YouTube">YouTube</a>
                        <a class="social-network soundcloud" href="#soundcloud" title="SoundCloud">SoundCloud</a>
                    </div>
                    <div class="info">
                        <h3 title="About the artist">About the artist</h3>
                        <p>
                            Justin Drew Bieber is a Canadian pop musician, actor, and singer-songwriter. Bieber was discovered in 2008 by American talent manager Scooter Braun, who came <a href="#biebers-videos" title="Bieber's Videos">across Bieber's videos</a> on YouTube and later became his manager. Justin Drew Bieber is a Canadian pop musician, actor, and singer-songwriter. Bieber was discovered in 2008 by American talent manager Scooter Braun, who came across Bieber's videos on YouTube and later became his manager.
                        </p>
                        <h3 title="History">History</h3>
                        <p>
                            Braun arranged for him to meet with entertainer Usher Raymond in Atlanta, Georgia, and Bieber was signed to Raymond Braun Media Group (RBMG), and then to an Island Records recording contract offered by record executive L.A. Reid.
                        </p>
                    </div>
                </div>
                <h2 title="Approved Videos Using Song (3)">Approved Videos Using Song (3)</h2>
                <div id="approved-videos" class="recommended block">
                    <a class="action prev" href="#action-prev" title="Previous">Previous</a>
                    <ul>
                        <li>
                            <div class="photo">
                                <img src="<?php echo WWW; ?>assets/images/dashboard/approved-video.jpg" alt="Slipknot" />
                                <div class="play"></div>
                            </div>
                            <div class="title">
                                Some video title by <a href="dashboard_campaign-youtuber.php" title="Kingsley">Kingsley</a>
                            </div>
                        </li>
                        <li>
                            <div class="photo">
                                <img src="<?php echo WWW; ?>assets/images/dashboard/approved-video.jpg" alt="Slipknot" />
                                <div class="play"></div>
                            </div>
                            <div class="title">
                                Some video title by <a href="dashboard_campaign-youtuber.php" title="Kingsley">Kingsley</a>
                            </div>
                        </li>
                        <li>
                            <div class="photo">
                                <img src="<?php echo WWW; ?>assets/images/dashboard/approved-video.jpg" alt="Slipknot" />
                                <div class="play"></div>
                            </div>
                            <div class="title">
                                Some video title by <a href="dashboard_campaign-youtuber.php" title="Kingsley">Kingsley</a>
                            </div>
                        </li>
                    </ul>
                    <a class="action next" href="#action-next" title="Next">Next</a>
                </div>
				 <h2 class="reached-last" title="Audience reached the Last">
                    <span class="title">Audience reached the Last</span>
                    <!--<div class="reached-last">
                        30 Days
                        <ul class="reached-last">
                            <li>30 Days</li>
                            <li>60 Days</li>
                            <li>90 Days</li>
                        </ul>-->
                        <select>
                            <option>30 Days</option>
                            <option>60 Days</option>
                            <option>90 Days</option>
                        </select>
                        <span class="select"></span>
                    <!--</div>-->
                </h2>
                <div class="recommended block">
                    <div class="reach-container">
						<canvas id="myReach" height="230"></canvas>
					</div>
					<script type="text/javascript">
						$(document).ready(function() {
							var lineChartData = {
								labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
								datasets: [
									{
										label: "Audience Reach",
										fillColor: "rgba(256,130,115,.2",
										strokeColor: "rgba(220,220,220,1)",
										pointColor: "rgba(220,220,220,1)",
										pointStrokeColor: "#fff",
										pointHighlightFill: "#FB8873",
										pointHighlightStroke: "#FB8873",
										data: [65, 59, 80, 81, 56, 55, 40, 60, 92, 304, 500, 628]
									}
								]
							}
							var canvas = document.getElementById("myReach");
							function fitToContainer(canvas){
								canvas.style.width='100%';
								canvas.width  = canvas.offsetWidth;
							}
							fitToContainer(canvas);
							var reachLine = document.getElementById("myReach").getContext("2d");
							window.myLine = new Chart(reachLine).Line(lineChartData);
						});
					</script>
                </div>
				<div class="campaign-container">
					<div class="left">
						<h2 title="Demographics">Demographics</h2>
						<div class="demographics block">
							<div class="demographic-chart">
								<div class="demographic-icon">
									
								</div>
								<canvas id="myDemographic" width="175" height="175"></canvas>
								<script type="text/javascript">
									$(document).ready(function() {
										Chart.defaults.global = {
											showTooltips: false
										}
										var pieData = [
											{
												value: 300,
												color:"#5f8ca3",
												label: "Boy"
											},
											{
												value: 200,
												color:"#fe8974",
												label: "Girl"
											},
										];
										window.onload = function() {
											var ctx = document.getElementById("myDemographic").getContext("2d");
											window.myPie = new Chart(ctx).Pie(pieData);
										};
									});
								</script>
							</div>
							<div class="demographic-stats">
								<div class="row">
									<span class="percent">40%</span> <div class="color girl"></div> <span class="gender">Female</span>
								</div>
								<div class="row">
									<span class="percent">60%</span> <div class="color boy"></div> <span class="gender">Male</span>
								</div>
							</div>
						</div>
					</div>
					<div class="right">
						<h2 title="Map">Map</h2>
						<div class="map block">
							<div class="maparea1">
								<div class="map">
									<span>Please enable JavaScript</span>
								</div>
							</div>
							
							<script type="text/javascript">
								$(document).ready(function() {
									$(".map").mapael({
										map : {
											name : "world_countries",
											defaultArea: {
												attrs: {
													fill: "#CCCCCC",
													stroke: "#aaaaaa",
												},
												attrsHover: {
													fill: "#FE8974",
												}
											}
										}
									});
								});
							</script>
						</div>
					</div>
				</div>
            </div>
<?php require 'dashboard_footer.php'; ?>