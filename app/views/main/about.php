<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>
    </head>
    <body class="<?php $res->pathClass(); ?>">
        <div id="app">
            <?php $res->partial('header'); ?>
            <main>
                <div class="page">
                    <h1>About</h1>
                    <p>Sell In Public is a community for builders and creators to share tips and ideas for sales and marketing. It was just built and launched the weekend of February 2-4, 2024. It is a very, very early alpha version of the site.</p>
                    <p>All of the code is open source and can be found on Github at <a href="https://github.com/dashboardq/sellinpublic">https://github.com/dashboardq/sellinpublic</a></p>
                    <p>The community is open for anyone to set up an account but in order to moderate spam, new accounts have a posting delay before a post becomes public (currently it is set to 48 hours). As a user posts more, their delay will come down until it is a 1 minute delay. Accounts in good standing will have a delay of only 1 minute.</p>
                    <p>There is a lot more to come soon. Mondays are my day off where I completely shut everything down and get away from all business communication (with the exception of business emergencies). I'll continue working on everything on Tuesday, February 6, 2024.
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
		<?php $res->partial('foot'); ?>
    </body>
</html>
