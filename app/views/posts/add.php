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
                    <h2>Add A Post</h2>

                    <?php if($delay != '1 minute'): ?>
                    <div class="notice warn">
                        <p>New accounts have a delay added before the post will become public. The delay will decrease over time. Your current delay is <?php esc($delay); ?>.</p>
                    </div>
                    <?php endif; ?>

                    <?php $res->html->messages(); ?>
                    <form method="POST">
                        <?php $res->html->textareaRaw('Introduce yourself or post an update...', 'post', '', '', 'id="post"'); ?>
                        <p data-max="240" data-watch="#post">240 characters max</p>

                        <?php $res->html->submit('Post'); ?>
                    </form>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

