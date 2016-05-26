<?php require 'header.php'; ?>
            <div class="page-title">
                <h2 title="Sign up for Songsly">Sign up for Songsly</h2>
            </div>
            <div class="sign-up container">
                <div class="famous block">
                    <h3 title="Becoming famous is easy as 1, 2, 3...">Becoming famous is easy as 1, 2, 3...</h3>
                    <div class="inner">
                        <span class="line"></span>
                        <span class="number one">1</span>
                        <div class="number">
                            <span></span>
                            <p>
                                some text to explain the step here
                            </p>
                        </div>
                        <span class="number two">2</span>
                        <div class="number two">
                            <span></span>
                            <p>
                                some text to explain the step here
                            </p>
                        </div>
                        <span class="number three">3</span>
                        <div class="number three">
                            <span></span>
                            <p>
                                some text to explain the step here
                            </p>
                        </div>
                    </div>
                </div>
                <form id="sign-up" name="sign-up" method="post" action="#sign-up">
                    <fieldset>
                        <div>
                            <input id="name" name="name" class="error" type="text" placeholder="Full Name" />
                            <span class="msg error">Please fill in this field</span>
                        </div>
                        <div>
                        <input id="email" name="email" type="text" placeholder="Email Address" />
                        <span class="msg valid">Email address is awesome</span>
                        </div>
                        <div>
                            <input id="username" name="username" type="text" placeholder="Username" />
                        </div>
                        <div>
                            <input id="password" name="password" type="password" placeholder="Password" />
                        </div>
                        <div>
                            <input id="sign_up_submit" name="sign_up_submit" class="button" type="submit" value="Create Your Account" />
                        </div>
                    </fieldset>
                </form>
            </div>
<?php require 'footer.php'; ?>