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
                    <h2>Add A Post</h2>

                    <div class="notice warn">
                        <p>New accounts have a 48 hour delay until the post will become public.</p>
                    </div>

                    <?php $res->html->messages(); ?>
                    <form method="POST">
                        <textarea name="post" placeholder="Introduce yourself or post an update..."></textarea>
                        <p>240 characters max</p>

                        <?php $res->html->submit('Post'); ?>
                    </form>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
		<?php $res->partial('foot'); ?>
    </body>
</html>

