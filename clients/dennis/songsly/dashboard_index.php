<?php require 'dashboard_header.php'; ?>
            <?php if(!isset($_GET['musician']) == true) { /* youtuber */ ?>
                <div class="left">
                    <h2 title="Quick Look">Quick Look<a href="<?php echo WWW; ?>dashboard_earnings.php" title="View Earnings">View Earnings</a></h2>
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
                            Current Balance
                            <span class="number">$4,389</span>
                        </span>
                        <span class="last-month">
                            Last Month
                            <span class="number">$59,521</span>
                        </span>
                    </div>
                </div>
                <div class="right">
                    <h2 title="Recommended for you">Recommended for you</h2>
                    <div class="recommended block">
                        <a class="action prev" href="#action-prev" title="Previous">Previous</a>
                        <ul>
                            <li>
                                <div class="photo">
                                    <img src="<?php echo WWW; ?>assets/images/dashboard/recommended-music.jpg" alt="Slipknot" />
                                    <div class="play">
                                        <span class="title">All hope is gone or is it<span>Slipknot</span></span>
                                        <span class="price">$50</span>
                                    </div>
                                </div>
                                <h3 title="Slipknot">Slipknot</h3>
                                <span class="title-stats">All hope is gone or is it</span>
                                <a class="button" href="#use-song" title="Use Song">Use Song</a>
                            </li>
                            <li>
                                <div class="photo">
                                    <img src="<?php echo WWW; ?>assets/images/dashboard/recommended-music.jpg" alt="Slipknot" />
                                    <div class="play">
                                        <span class="title">All hope is gone or is it<span>Slipknot</span></span>
                                        <span class="price">$50</span>
                                    </div>
                                </div>
                                <h3 title="Slipknot">Slipknot</h3>
                                <span class="title-stats">All hope is gone or is it</span>
                                <a class="button" href="#use-song" title="Use Song">Use Song</a>
                            </li>
                            <li>
                                <div class="photo">
                                    <img src="<?php echo WWW; ?>assets/images/dashboard/recommended-music.jpg" alt="Slipknot" />
                                    <div class="play">
                                        <span class="title">All hope is gone or is it<span>Slipknot</span></span>
                                        <span class="price">$50</span>
                                    </div>
                                </div>
                                <h3 title="Slipknot">Slipknot</h3>
                                <span class="title-stats">All hope is gone or is it</span>
                                <a class="button" href="#use-song" title="Use Song">Use Song</a>
                            </li>
                        </ul>
                        <a class="action next" href="#action-next" title="Next">Next</a>
                    </div>
                </div>
                <div class="full">
                    <h2 title="Find Music">Find Music</h2>
                    <div class="find-music block">
                        <form id="search" name="search" action="#search" method="post">
                            <fieldset>
                                <input id="search_term" name="search_term" type="text" placeholder="Add a filter from the left or search for song, album, genre, musician..." />
                                <input id="search_submit" name="search_submit" type="submit" value="Search" />
                            </fieldset>
                        </form>
                        <table>
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Musician</th>
                                    <th>Song Title</th>
                                    <th>Pays</th>
                                    <th>Genre</th>
                                    <th>Popularity</th>
                                    <th><div class="list-grid"><a class="list current" href="#list">List</a> <a class="grid" href="#grid">Grid</a></div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                    <td>Justin Bieber</td>
                                    <td>From Mars to Sirius</td>
                                    <td>$50</td>
                                    <td>Rock, Metal</td>
                                    <td>*****<span class="gray">**</span></td>
                                    <td><a class="button" href="#use-song" title="Use Song">Use Song</a></td>
                                </tr>
                                <tr>
                                    <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                    <td>Justin Bieber</td>
                                    <td>From Mars to Sirius</td>
                                    <td>$50</td>
                                    <td>Rock, Metal</td>
                                    <td>*****<span class="gray">**</span></td>
                                    <td><a class="button" href="#use-song" title="Use Song">Use Song</a></td>
                                </tr>
                                <tr>
                                    <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                    <td>Justin Bieber</td>
                                    <td>From Mars to Sirius</td>
                                    <td>$50</td>
                                    <td>Rock, Metal</td>
                                    <td>*****<span class="gray">**</span></td>
                                    <td><a class="button" href="#use-song" title="Use Song">Use Song</a></td>
                                </tr>
                                <tr>
                                    <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-from-mars.jpg" alt="From Mars to Sirius" /></td>
                                    <td>Justin Bieber</td>
                                    <td>From Mars to Sirius</td>
                                    <td>$50</td>
                                    <td>Rock, Metal</td>
                                    <td>*****<span class="gray">**</span></td>
                                    <td><a class="button" href="#use-song" title="Use Song">Use Song</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else { /* musician */ ?>
                <div class="left">
                    <a class="button create-new-campaign" href="<?php echo WWW; ?>dashboard_create-campaign.php" title="Create New Campaign">Create New Campaign</a>
                    <h2 title="Active Campaigns">Active Campaigns (3)<a href="<?php echo WWW; ?>dashboard_campaigns.php" title="View Campaigns">View All</a></h2>
                    <div class="active-campaigns block">
                        <ul>
                            <li>
                                <h3 title="Punk Rock Songs Campaign">Punk Rock Songs Campaign</h3>
                                <span class="stats money">$2500</span>
                                <span class="stats views">133,456</span>
                                <span class="stats date">5 Days</span>
                                <span class="stats videos">2</span>
                            </li>
                            <li>
                                <h3 title="Everlong Campaign">Everlong Campaign</h3>
                                <span class="stats money">$2500</span>
                                <span class="stats views">133,456</span>
                                <span class="stats date">5 Days</span>
                                <span class="stats videos">2</span>
                            </li>
                            <li>
                                <h3 title="Folk Album">Folk Album</h3>
                                <span class="stats money">$2500</span>
                                <span class="stats views">133,456</span>
                                <span class="stats date">5 Days</span>
                                <span class="stats videos">2</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="right">
                    <h2 title="Recommended for you">Recommended for you</h2>
                    <div class="recommended block">
                        <a class="action prev" href="#action-prev" title="Previous">Previous</a>
                        <ul>
                            <li>
                                <div class="photo">
                                    <img src="<?php echo WWW; ?>assets/images/dashboard/recommended-kingsley.jpg" alt="Slipknot" />
                                    <div class="stats">
                                        <span class="title">Kingsley</span>
                                        <span class="stats location">Los Angeles, CA</span>
                                        <span class="stats subscribers">1,9M</span>
                                        <span class="stats views">941M</span>
                                        <span class="stats videos">150</span>
                                    </div>
                                </div>
                                <h3 title="Kingsley">Kingsley</h3>
                                <span class="stats subscribers">1,9M</span>
                                <span class="stats views">941M</span>
                                <span class="stats videos">150</span>
                                <a class="button" href="#invite-publisher" title="Invite Publisher">Invite Publisher</a>
                            </li>
                            <li>
                                <div class="photo">
                                    <img src="<?php echo WWW; ?>assets/images/dashboard/recommended-kingsley.jpg" alt="Slipknot" />
                                    <div class="stats">
                                        <span class="title">Kingsley</span>
                                        <span class="stats location">Los Angeles, CA</span>
                                        <span class="stats subscribers">1,9M</span>
                                        <span class="stats views">941M</span>
                                        <span class="stats videos">150</span>
                                    </div>
                                </div>
                                <h3 title="Kingsley">Kingsley</h3>
                                <span class="stats subscribers">1,9M</span>
                                <span class="stats views">941M</span>
                                <span class="stats videos">150</span>
                                <a class="button" href="#invite-publisher" title="Invite Publisher">Invite Publisher</a>
                            </li>
                            <li>
                                <div class="photo">
                                    <img src="<?php echo WWW; ?>assets/images/dashboard/recommended-kingsley.jpg" alt="Slipknot" />
                                    <div class="stats">
                                        <span class="title">Kingsley</span>
                                        <span class="stats location">Los Angeles, CA</span>
                                        <span class="stats subscribers">1,9M</span>
                                        <span class="stats views">941M</span>
                                        <span class="stats videos">150</span>
                                    </div>
                                </div>
                                <h3 title="Kingsley">Kingsley</h3>
                                <span class="stats subscribers">1,9M</span>
                                <span class="stats views">941M</span>
                                <span class="stats videos">150</span>
                                <a class="button" href="#invite-publisher" title="Invite Publisher">Invite Publisher</a>
                            </li>
                        </ul>
                        <a class="action next" href="#action-next" title="Next">Next</a>
                    </div>
                </div>
                <div class="full">
                    <h2 title="Find Music">Find Publishers</h2>
                    <div class="find-music block">
                        <form id="search" name="search" action="#search" method="post">
                            <fieldset>
                                <input id="search_term" name="search_term" type="text" placeholder="Add a filter from the left or search for publisher, username, type, location..." />
                                <input id="search_submit" name="search_submit" type="submit" value="Search" />
                            </fieldset>
                        </form>
                        <table>
                            <thead>
                                <tr>
                                    <th>Profile Pic</th>
                                    <th>Publisher's Name</th>
                                    <th>Location</th>
                                    <th>Subscribers</th>
                                    <th>Video Views</th>
                                    <th>Videos</th>
                                    <th>Type</th>
                                    <th><div class="list-grid"><a class="list current" href="#list">List</a> <a class="grid" href="#grid">Grid</a></div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-kingsley.jpg" alt="Kingsley" /></td>
                                    <td>Kingsley</td>
                                    <td>Los Angeles, CA</td>
                                    <td>1,234,565</td>
                                    <td>931,328,704</td>
                                    <td>150</td>
                                    <td>Comedy</td>
                                    <td><a class="button invite" href="#invite-publisher" title="Invite Publisher">Invite Publisher</a></td>
                                </tr>
                                <tr>
                                    <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-kingsley.jpg" alt="Kingsley" /></td>
                                    <td>Kingsley</td>
                                    <td>Los Angeles, CA</td>
                                    <td>1,234,565</td>
                                    <td>931,328,704</td>
                                    <td>150</td>
                                    <td>Comedy</td>
                                    <td><a class="button invite" href="#invite-publisher" title="Invite Publisher">Invite Publisher</a></td>
                                </tr>
                                <tr>
                                    <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-kingsley.jpg" alt="Kingsley" /></td>
                                    <td>Kingsley</td>
                                    <td>Los Angeles, CA</td>
                                    <td>1,234,565</td>
                                    <td>931,328,704</td>
                                    <td>150</td>
                                    <td>Comedy</td>
                                    <td><a class="button invite" href="#invite-publisher" title="Invite Publisher">Invite Publisher</a></td>
                                </tr>
                                <tr>
                                    <td><img src="<?php echo WWW; ?>assets/images/dashboard/find-kingsley.jpg" alt="Kingsley" /></td>
                                    <td>Kingsley</td>
                                    <td>Los Angeles, CA</td>
                                    <td>1,234,565</td>
                                    <td>931,328,704</td>
                                    <td>150</td>
                                    <td>Comedy</td>
                                    <td><a class="button invite" href="#invite-publisher" title="Invite Publisher">Invite Publisher</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
<?php require 'dashboard_footer.php'; ?>