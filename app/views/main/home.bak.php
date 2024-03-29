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
                    <h1>Latest</h1>
                    <div class="notice">
                        <p>Sell In Public was just built the weekend of February 2-4, 2024 and is currently in a very early alpha state. There are many changes and updates still to come.</p>
                    </div>
                    <?php $res->html->messages(); ?>
                </div>

                <?php foreach($posts as $post): ?>
                <div class="post">
                    <div class="meta">
                        <span class="profile"><?php esc(substr($post->data['username'], 0, 1)); ?></span> 
                        <span class="name"><?php esc($post->data['user']['name']); ?></span> 
                        @<span class="username"><?php esc($post->data['username']); ?></span> 
                        <span class="published_at"><?php esc($post->data['published_at']->format('Y-m-d G:i') . ' UTC'); ?></span> 
                    </div>
                    <p><?php echo nl2br(_esc($post->data['post'])); ?></p>
                </div>
                <?php endforeach; ?>

                <?php if($pagination): ?>
                <div class="pagination">
                    <p>Results <?php esc($pagination['current_result'] . '-' . $pagination['current_result_last'] . ' of ' . $pagination['total_results']); ?> <?php if($pagination['page_previous'] != $pagination['page_current']): ?>&lt; <a href="<?php esc($pagination['url_previous']); ?>">Prev</a><?php endif; ?> <?php if($pagination['page_next'] != $pagination['page_current']): ?><a href="<?php esc($pagination['url_next']); ?>">Next</a> &gt;<?php endif; ?></p>
                </div>
                <?php endif; ?>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>
