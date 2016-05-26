<?php require 'header.php'; ?>
            <div class="page-title">
                <h2 title="Great! Now complete your profile.">Great! Now complete your profile.</h2>
            </div>
            <div class="sign-up container">
                <div class="page">
                    <form id="sign-up" name="sign_up" action="#sign-up method="post">
                        <fieldset>
                            <div class="avatar">
                                <img src="<?php echo WWW; ?>assets/images/pages/team.jpg" alt="Avatar" />
                                <a href="#upload" title="Upload Avatar">Upload Avatar</a>
                            </div>
                            <input id="name" name="name" type="text" placeholder="Artist Name" />
                            <textarea id="bio" name="bio" cols="10" rows="10" placeholder="Add your bio"></textarea>
                            <select id="genre" name="genre">
                                <option>Pick a genre</option>
                                <option value="Rap">Rap</option>
                            </select>
                            <input id="facebook" name="facebook" type="text" placeholder="Facebook username" />
                            <input id="twitter" name="twitter" type="text" placeholder="Twitter username" />
                            <input id="song_url" name="song_url" type="text" placeholder="Type the URL of your song" />
                            <input id="sign_up_submit" name="sign_up_submit" class="button" type="submit" value="Finish and Pay $5" />
                        </fieldset>
                    </form>
                </div>
            </div>
<?php require 'footer.php'; ?>