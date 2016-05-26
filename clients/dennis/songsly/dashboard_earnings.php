<?php require 'dashboard_header.php'; ?>
            <div class="left">
                <h2 title="Earnings Overview">Earnings Overview</h2>
                <div class="quick-look block">
                    <span class="current-balance first-child">
                        Current Balance
                        <span class="number">$12,530</span>
                    </span>
                    <span class="last-month first-child">
                        Last Month
                        <span class="number">$54,389</span>
                    </span>
                    <span class="current-balance">
                        All Time Earnings
                        <span class="number">$194,389</span>
                    </span>
                </div>
            </div>
            <div class="right">
                <h2 title="Earnings for the Last">Earnings for the Last</h2>
                <div class="recommended block">
                    <div id="graph-wrapper">
                    	<div class="graph-container">
                    		<div id="graph-lines"></div>
                    	</div>
                    </div>
                    <script type="text/javascript">
                    $(document).ready(function () {
                    	// Graph Data
                    	var graphData = [{
                    			data: [ [6, 0], [7, 125], [8, 80], [9, 175], [10, 130], [11, 510], [12, 130], [13, 510], [14, 525], [15, 650] ],
                    			color: '#999999',
                                points: { radius: 5, fillColor: '#fe8974' }
                    		}
                    	];
                    
                    	// Lines Graph
                    	$.plot($('#graph-lines'), graphData, {
                    		series: {
                    			points: {
                    				show: true,
                    				radius: 5
                    			},
                    			lines: {
                    				show: true
                    			},
                    			shadowSize: 0
                    		},
                    		grid: {
                    			color: '#f1f1f1',
                    			borderColor: '#dddddd',
                    			borderWidth: 1,
                    			hoverable: true
                    		},
                    		xaxis: {
                    			tickColor: 'transparent',
                    			tickDecimals: 2
                    		},
                    		yaxis: {
                    			tickSize: 100
                    		}
                    	});
                    
                    	// Tooltip
                    	function showTooltip(x, y, contents) {
                    		$('<div id="tooltip">' + contents + '</div>').css({
                    			top: y - 16,
                    			left: x + 20
                    		}).appendTo('body').fadeIn();
                    	}
                    
                    	var previousPoint = null;
                    
                    	$('#graph-lines, #graph-bars').bind('plothover', function (event, pos, item) {
                    		if (item) {
                    			if (previousPoint != item.dataIndex) {
                    				previousPoint = item.dataIndex;
                    				$('#tooltip').remove();
                    				var x = item.datapoint[0],
                    					y = item.datapoint[1];
                    					showTooltip(item.pageX, item.pageY, y + '<br />' + x + ' April');
                    			}
                    		} else {
                    			$('#tooltip').remove();
                    			previousPoint = null;
                    		}
                    	});
                    });
                    
                    /*placeholder = $('.graph-container');
                    
                    placeholder.resize(function () {
                        $(".poop").text("Placeholder is now " + $(this).width() + "x" + $(this).height() + " pixels");
                    });*/
                    </script>
                </div>
            </div>
            <div class="full">
                <h2 title="Campaigns Involving You">Campaigns Involving You</h2>
                <div class="find-music block">
                    <table class="no-margin-top">
                        <thead>
                            <tr>
                                <th>Cover</th>
                                <th>Created By</th>
                                <th>Campaign Title</th>
                                <th>Earnings</th>
                                <th>Audience Reached</th>
                                <th>Pay Per View</th>
                                <th><div class="list-grid"><a class="list current" href="#list">List</a> <a class="grid" href="#grid">Grid</a></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                <td>Justin Bieber</td>
                                <td>Campaign song Awesome 1</td>
                                <td>$789</td>
                                <td>39,450</td>
                                <td>$0.02</td>
                                <td><div class="action"><a class="view" href="<?php echo WWW; ?>dashboard_campaign-youtuber.php">View</a> <a class="edit" href="#edit">Edit</a></div></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                <td>Justin Bieber</td>
                                <td>Campaign song Awesome 1</td>
                                <td>$789</td>
                                <td>39,450</td>
                                <td>$0.02</td>
                                <td><div class="action"><a class="view" href="<?php echo WWW; ?>dashboard_campaign-youtuber.php">View</a> <a class="edit" href="#edit">Edit</a></div></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                <td>Justin Bieber</td>
                                <td>Campaign song Awesome 1</td>
                                <td>$789</td>
                                <td>39,450</td>
                                <td>$0.02</td>
                                <td><div class="action"><a class="view" href="<?php echo WWW; ?>dashboard_campaign-youtuber.php">View</a> <a class="edit" href="#edit">Edit</a></div></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                <td>Justin Bieber</td>
                                <td>Campaign song Awesome 1</td>
                                <td>$789</td>
                                <td>39,450</td>
                                <td>$0.02</td>
                                <td><div class="action"><a class="view" href="<?php echo WWW; ?>dashboard_campaign-youtuber.php">View</a> <a class="edit" href="#edit">Edit</a></div></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                <td>Justin Bieber</td>
                                <td>Campaign song Awesome 1</td>
                                <td>$789</td>
                                <td>39,450</td>
                                <td>$0.02</td>
                                <td><div class="action"><a class="view" href="<?php echo WWW; ?>dashboard_campaign-youtuber.php">View</a> <a class="edit" href="#edit">Edit</a></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
<?php require 'dashboard_footer.php'; ?>