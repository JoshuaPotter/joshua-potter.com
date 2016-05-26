<?php require 'dashboard_header.php'; ?>
            <form id="create-campaign" name="create-campaign" action="#create-campaign" method="post">
                <fieldset>
                    <div class="left">
                        <h2 title="New Campaign Information">New Campaign Information</h2>
                        <div class="new-campaign block">
                            <div class="clear">
                                <label for="title">Title</label>
                                <input id="title" name="title" type="text" />
                            </div>
                            <div class="clear">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" cols="10" rows="10"></textarea>
                            </div>
                            <div class="clear">
                                <label for="language">Language</label>
                                <select id="language" name="language">
                                    <option value="English">English</option>
                                    <option value="Spanish">Spanish</option>
                                </select>
                            </div>
                            <div class="clear">
                                <label for="genre">Genre</label>
                                <input id="genre" name="genre" type="text" />
                            </div>
                        </div>
                        <h2 title="Select the Type of Campaign">Select the Type of Campaign</h2>
                        <div class="type-of-campaign block">
                            <a class="custom" href="#custom-campaign">
                                <span>Custom Campaign</span>
                                A publisher needs to apply for your Campaign, and you have to approve. Once approved a set amount of budget will have to add whatever else text you need here...
                            </a>
                            <a class="public" href="#public-campaign">
                                <span>Public Campaign</span>
                                Your campaign will be open to the public and you don't have to approve. Once approved a set amount of budget will have to add whatever else text you need here...
                            </a>
                            <input id="type_of_campaign" name="type_of_campaign" type="hidden" value="" />
                        </div>
                        <h2 title="Public Campaign Settings">Public Campaign Settings</h2>
                        <div class="public-campaign block">
                            <div class="clear">
                                <label for="target_country">Target Country</label>
                                <select id="target_country" name="target_country">
                                    <option value="United States">United States</option>
                                    <option value="Spain">Spain</option>
                                </select>
                            </div>
                            <div class="clear">
                                <label for="desired_reach">Desired Reach</label>
                                <input id="desired_reach" name="desired_reach" type="range" min="0" max="5000" value="1500" />
                            </div>
                            <div class="clear">
                                <label for="available_budget">Available Budget</label>
                                <input id="available_budget" name="available_budget" type="range" min="0" max="5000" value="350" />
                            </div>
                            <div class="clear">
                                <label for="state_date">State Date</label>
                                <select id="start_month" name="start_month">
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                </select>
                                <select id="start_day" name="start_day">
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                </select>
                                <select id="start_year" name="start_year">
                                    <option value="2013">2013</option>
                                    <option value="2014">2014</option>
                                </select>
                            </div>
                        </div>
                        <h2 title="Upload Your Song">Upload Your Song</h2>
                        <div class="upload-song block">
                            <div class="cover">
                                Upload 640x640<br />
                                Cover
                            </div>
                            <span class="upload">Drag n drop or click to browse for a song</span>
                            <p>
                                You can also <a href="#link-your-song" title="link to your song">link to your song</a>. We support AIFF, WAVE, FLAC, OGG, MP2, MP3, AAC, AMR and WMA files. Max. file size 50MB.
                            </p>
                        </div>
                        <div class="agree">
                            <input id="agree" name="agree" type="checkbox" value="1" /> <label for="agree">I agree to the <a href="<?php echo WWW; ?>privacy-terms.php" title="Terms and Conditions">Terms and Conditions</a></label>
                        </div>
                    </div>
                    <div class="right">
                        <div class="fixed">
                            <h2 title="Summary">Summary</h2>
                            <div class="summary block">
                                <h3 title="Shakalaka Campaign">Shakalaka Campaign</h3>
                                <span class="left">Est. Reach:</span>
                                <span class="right">200k - 500k</span>
                                <span class="left">Budget:</span>
                                <span class="right">$3,456</span>
                                <span class="left">Days:</span>
                                <span class="right">30</span>
                                <span class="left total">Total Price:</span>
                                <span class="right total">$3,456</span>
                                <input id="submit" name="submit" class="button" type="submit" value="Continue" />
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
<?php require 'dashboard_footer.php'; ?>