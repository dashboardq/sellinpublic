<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>
    </head>
    <body class="<?php $res->pathClass(); ?>">
        <?php $res->partial('view_app_before'); ?>
        <div id="app">
            <?php $res->partial('header'); ?>
            <main>
                <div class="page">
                    <h1>Pricing</h1>
                    <ul class="columns">
                        <li>
                            <h2>Free</h2>
                            <h3>$0 / month</h3>
                            <a href="/login" class="button">Get Started</a>
                            <ul>
                                <li>Access to basic features</li>
                                <li>Public API access</li>
                                <?php /*
                                <li>10 private message credits</li>
                                 */ ?>
                            </ul>
                        </li>
                        <li class="card -highlight">
                            <h2>Pro</h2>
                            <h3>$8 / month</h3>
                            <a href="/login" class="button">Get Started</a>
                            <ul>
                                <li>Access to pro features</li>
                                <li>Public &amp; Private API access</li>
                                <?php /*
                                <li>100 private message credits</li>
                                 */ ?>
                                <li>Optional domain username</li>
                                <li>Early access to upcoming beta features and access to pro features</li>
<?php /*
                                <li>Enhanced profile options</li>
                                <li>Ability to post in restricted marketplace subdirectories</li>
 */ ?>
                            </ul>
                        </li>
                        <li class="card">
                            <h2>Custom</h2>
                            <h3>Get In Touch</h3>
                            <a href="/login" class="button">Get Started</a>
                            <ul>
                                <li>If you are not seeing a plan that meets your needs, please feel free to reach out.</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>
