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
                    <h2>Flag</h2>

                    <?php $res->html->messages(); ?>
                    <?php foreach($posts as $post): ?>
                    <?php $res->partial('post', ['post' => $post]); ?>
                    <?php endforeach; ?>

                    <form method="POST">
                        <?php $res->html->submit('Flag Post'); ?>
                    </form>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

