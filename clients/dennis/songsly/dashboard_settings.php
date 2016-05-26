<?php require 'dashboard_header.php'; ?>
            <form id="settings" name="settings" action="#settings" method="post">
                <fieldset>
                    <div class="left">
                        <h2 title="Basic Information">Basic Information</h2>
                        <div class="block">
                            <div class="clear">
                                <label for="user-photo">&#160;</label>
                                <div class="user-photo">
                                    <img src="<?php echo WWW; ?>assets/images/pages/team.jpg" alt="Dennis Hegstad" />
                                    <a href="#upload" title="Upload new avatar">Upload new avatar</a>
                                </div>
                            </div>
                            <div class="clear">
                                <label for="bio">Bio</label>
                                <textarea id="bio" name="bio" cols="10" rows="10"></textarea>
                            </div>
                            <div class="clear">
                                <label for="email_address">Email Address</label>
                                <input id="email_address" name="email_address" type="text" />
                            </div>
                            <div class="clear">
                                <label for="username">Username</label>
                                <input id="username" name="username" type="text" />
                            </div>
                            <div class="clear">
                                <label for="website">Website</label>
                                <input id="website" name="website" type="text" />
                            </div>
                            <div class="clear">
                                <label for="display_name">Display Name</label>
                                <input id="display_name" name="display_name" type="text" />
                            </div>
                        </div>
                        <h2 title="Notifications">Notifications</h2>
                        <div class="block">
                            <div class="clear">
                                <span class="label">Email me when...</span>
                                <span class="input checkbox">
                                    <a class="check-toggle" href="#notifications_hack_me">Yes<span>No</span></a>
                                    <span class="inner-label">Someone tries to hack me</span>
                                </span>
                                <input id="notifications_hack_me" name="notifications_hack_me" type="checkbox" checked="checked" />
                            </div>
                        </div>
                        <h2 title="Email Preferences">Email Preferences</h2>
                        <div class="block">
                            <div class="clear">
                                <span class="label">Receive emails...</span>
                                <span class="input checkbox">
                                    <a class="check-toggle" href="#email_pref_spotlight">Yes<span>No</span></a>
                                    <span class="inner-label">When Songsly has a Spotlight</span>
                                </span>
                                <input id="email_pref_spotlight" name="email_pref_spotlight" type="checkbox" checked="checked" />
                            </div>
                            <div class="clear">
                                <span class="label">&#160;</span>
                                <span class="input checkbox">
                                    <a class="check-toggle" href="#email_pref_daily_newsletter">Yes<span>No</span></a>
                                    <span class="inner-label">Daily Newsletter</span>
                                </span>
                                <input id="email_pref_daily_newsletter" name="email_pref_daily_newsletter" type="checkbox" checked="checked" />
                            </div>
                        </div>
                        <h2 title="Change Password">Change Password</h2>
                        <div class="block">
                            <div class="clear">
                                <label for="current_password">Current Password</label>
                                <input id="current_password" name="current_password" type="password" />
                            </div>
                            <div class="clear">
                                <label for="new_password">New Password</label>
                                <input id="new_password" name="current_password" type="password" />
                            </div>
                            <div class="clear">
                                <label for="verify_password">Verify Password</label>
                                <input id="verify_password" name="current_password" type="password" />
                            </div>
                        </div>
                        <h2 title="Connected Accounts">Connected Accounts</h2>
                        <div class="connected-accounts block">
                            <ul>
                                <li>
                                    <div class="connected-photo">
                                        <img src="<?php echo WWW; ?>assets/images/pages/team.jpg" alt="Dennis Hegstad" />
                                    </div>
                                    <div class="connected-info">
                                        <span class="connected-name">Dennis Hegstad</span>
                                        <span class="connected-logo"><img src="<?php echo WWW; ?>assets/images/dashboard/connected-youtube.jpg" alt="Dennis Hegstad" /></span>
                                    </div>
                                    <div class="connected-actions">
                                        <a class="button gray" href="#connected" title="Connected">Connected</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="connected-photo">
                                        <img src="<?php echo WWW; ?>assets/images/pages/team.jpg" alt="Dennis Hegstad" />
                                    </div>
                                    <div class="connected-info">
                                        <span class="connected-name">Dennis Hegstad</span>
                                        <span class="connected-logo"><img src="<?php echo WWW; ?>assets/images/dashboard/connected-youtube.jpg" alt="Dennis Hegstad" /></span>
                                    </div>
                                    <div class="connected-actions">
                                        <a class="button gray" href="#connected" title="Connected">Connected</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="right">
                        <div class="form-input">
                            <a class="button gray" href="#cancel" title="Cancel">Cancel</a>
                            <input id="submit" name="submit" class="button" type="submit" value="Save Changes" />
                        </div>
                    </div>
                </fieldset>
            </form>
<?php require 'dashboard_footer.php'; ?>