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
                    <?php $res->partial('view_notice_before'); ?>
                    <div class="notice">
                        <p>Sell In Public is currently being built (March 2024) and is currently in an alpha state. There are more changes and updates still to come.</p>
                    </div>
                    <?php $res->partial('view_notice_after'); ?>

                    <?php $res->html->messages(); ?>
                </div>

                <?php if(false): ?>
                <div class="post">
                    <div class="meta">
                        <span class="profile">a</span> 
                        <span class="name">Test</span> 
                        @<a href="/test" class="username">test</a> 
                        <a href="/test/1" class="published_at"><?php esc(elapsed(now())); ?></a> 
                    </div>
                    <p><?php echo \app\handlify(linkify(nl2br(_esc('This is a test post.')))); ?></p>

                    <div class="attachment attachment_text shown">
                        <button class="show">Show Additional Text</button>
                        <button class="hide">Hide Additional Text</button>
                        <p>This is some additional text.</p>
                    </div>

                    <?php $res->partial('post_actions', ['post' => ['replies' => 0, 'stars' => 0, 'replied' => false, 'id' => 1, 'username' => 'test', 'starred' => false, 'flagged' => false]]); ?>
                </div>
                <?php endif; ?>

                <?php foreach($posts as $post): ?>
                <div class="post">
                    <div class="meta">
                        <span class="profile"><?php esc(substr($post['username'], 0, 1)); ?></span> 
                        <span class="name"><?php esc($post['display_name']); ?></span> 
                        @<a href="/<?php esc($post['username']); ?>" class="username"><?php esc($post['username']); ?></a> 
                        <a href="/<?php esc($post['username']); ?>/<?php esc($post['id']); ?>" class="published_at"><?php esc(elapsed($post['published_tz'])); ?></a> 
                    </div>
                    <p><?php echo \app\handlify(linkify(nl2br(_esc($post['post'])))); ?></p>
                    <?php $res->partial('post_actions', compact('post')); ?>
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
