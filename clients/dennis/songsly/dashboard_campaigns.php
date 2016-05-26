<?php require 'dashboard_header.php'; ?>
            <div class="left">
                <h2 title="Campaigns Overview">Campaigns Overview</h2>
                <div class="quick-look block campaign-overview-quick-look">
                    <span class="current-balance first-child">
                        <span class="number">12,530</span>
						<div class="numcategory">Reached Today</div>
                    </span>
                    <span class="last-month first-child">
                        <span class="number">584,389</span>
						<div class="numcategory">All Time Reach</div>
                    </span>
                    <span class="current-balance">
                        <span class="number">$4,389</span>
						<div class="numcategory">Available Balance</div>
                    </span>
                    <span class="last-month">
                        <span class="number">$59,521</span>
						<div class="numcategory">Spent So Far</div>
                    </span>
                </div>
            </div>
            <div class="right">
                <h2 class="reached-last" title="Audience Reached the Last">
					<span class="title">Audience Reached the Last</span>

					<select>
						<option>30 Days</option>
						<option>60 Days</option>
						<option>90 Days</option>
					</select>
					<span class="select"></span>
				</h2>
                <div class="recommended block">
					<div class="reach-container">
						<canvas id="myReach" height="220"></canvas>
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
            </div>
            <div class="full">
                <h2 title="Campaign Details">Campaign Details</h2>
                <div class="find-music block">
                    <table class="no-margin-top">
                        <thead>
                            <tr class="table-head">
                                <th>Video</th>
                                <th>Campaign Title</th>
                                <th>Audience</th>
                                <th>Spend / Budget</th>
                                <th>Description / Annotation CTR</th>
                                <th>Days Left</th>
                                <th><div class="list-grid"><a class="list current" href="#list">List</a> <a class="grid" href="#grid">Grid</a></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                <td>Campaign song 1</td>
                                <td>345,843</td>
                                <td>$789 / $2500</td>
                                <td>45,45% / 67,57%</td>
                                <td>24</td>
                                <td><div class="action"><a class="view" href="#view">View</a> <a class="edit" href="#edit">Edit</a></div></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                <td>Campaign song 1</td>
                                <td>345,843</td>
                                <td>$789 / $2500</td>
                                <td>45,45% / 67,57%</td>
                                <td>24</td>
                                <td><div class="action"><a class="view" href="#view">View</a> <a class="edit" href="#edit">Edit</a></div></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                <td>Campaign song 1</td>
                                <td>345,843</td>
                                <td>$789 / $2500</td>
                                <td>45,45% / 67,57%</td>
                                <td>24</td>
                                <td><div class="action"><a class="view" href="#view">View</a> <a class="edit" href="#edit">Edit</a></div></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                <td>Campaign song 1</td>
                                <td>345,843</td>
                                <td>$789 / $2500</td>
                                <td>45,45% / 67,57%</td>
                                <td>24</td>
                                <td><div class="action"><a class="view" href="#view">View</a> <a class="edit" href="#edit">Edit</a></div></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                <td>Campaign song 1</td>
                                <td>345,843</td>
                                <td>$789 / $2500</td>
                                <td>45,45% / 67,57%</td>
                                <td>24</td>
                                <td><div class="action"><a class="view" href="#view">View</a> <a class="edit" href="#edit">Edit</a></div></td>
                            </tr>
                        </tbody>
                    </table>
				</div>
				<div class="pagination">
					<ul>
						<li><a href="#" class="pagination-btn"><i class="fa fa-caret-left"></i></a></li>

						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#" class="active">5</a></li>
						<li><a href="#">6</a></li>
						<li><a href="#">7</a></li>
						<li><a href="#">8</a></li>
						<li><a href="#">9</a></li>
						<li><a href="#">10</a></li>

						<li><a href="#" class="pagination-btn"><i class="fa fa-caret-right"></i></a></li>
					</ul>
				</div>
            </div>
			<div class="black-overlay"></div>
			<div class="campaign-overlay">
				<div class="container">
					<?php 
						include 'dashboard_campaign-musician.php';
					?>
				</div>
			</div>
<?php require 'dashboard_footer.php'; ?>