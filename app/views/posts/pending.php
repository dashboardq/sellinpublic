<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>
    </head>
    <body class="<?php $res->pathClass(); ?>">
        <?php $res->partial('view_app_before'); ?>
        <div id="app" class="columns_2">
            <?php $res->partial('header'); ?>
            <?php $res->partial('sidebar_account'); ?> 
            <main>
                <div class="page">
                    <h1>Pending</h1>
                    <div class="notice warn">
                        <p>The posts below will show up on timelines once the publish delay time has been reached.</p>
                    </div>
                    <?php $res->html->messages(); ?>
                </div>

                <?php foreach($posts as $post): ?>
                <div class="post">
                    <div class="meta">
                        <span class="profile"><?php esc(substr($post['username'], 0, 1)); ?></span> 
                        <span class="name"><?php esc($post['display_name']); ?></span> 
                        @<a href="/<?php esc($post['username']); ?>" class="username"><?php esc($post['username']); ?></a> 
                        <a href="/<?php esc($post['username']); ?>/<?php esc($post['id']); ?>" class="published_at"><?php esc(future($post['published_tz'])); ?></a> 
                    </div>
                    <p><?php echo \app\handlify(linkify(nl2br(_esc($post['post'])))); ?></p>
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

