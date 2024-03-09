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
                    <div class="post">
                        <div class="meta">
                            <span class="profile"><?php esc(substr($post['username'], 0, 1)); ?></span> 
                            <span class="name"><?php esc($post['display_name']); ?></span> 
                            @<span class="username"><?php esc($post['username']); ?></span> 
                            <span class="published_at"><?php esc($post['published_tz']->format('Y-m-d G:i T')); ?></span> 
                        </div>
                        <p><?php echo nl2br(_esc($post['post'])); ?></p>
                    </div>
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

