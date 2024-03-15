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
                    <h2>Reply</h2>

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

                    <?php if($delay != '1 minute'): ?>
                    <div class="notice warn">
                        <p>New accounts have a delay added before the post will become public. The delay will decrease over time. Your current delay is <?php esc($delay); ?>.</p>
                    </div>
                    <?php endif; ?>

                    <form method="POST">
                        <?php $res->html->textareaRaw('Reply to the message above...', 'post', '', '', 'id="post"'); ?>
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

