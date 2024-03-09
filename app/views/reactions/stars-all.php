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
                <?php $res->html->messages(); ?>

                <?php if(count($reactions) == 0): ?>
                <div class="page">
                    <p>No results.</p>
                </div>
                <?php endif; ?>

                <?php foreach($reactions as $reaction): ?>
                <div class="depth depth_0">
                    <div class="post">
                        <div class="meta">
                            <span class="profile"><?php esc(substr($reaction['post']['username'], 0, 1)); ?></span> 
                            <span class="name"><?php esc($reaction['post']['display_name']); ?></span> 
                            @<a href="/<?php esc($reaction['post']['username']); ?>" class="username"><?php esc($reaction['post']['username']); ?></a> 
                            <a href="/<?php esc($reaction['post']['username']); ?>/<?php esc($reaction['post']['id']); ?>" class="published_at"><?php esc(elapsed($reaction['post']['published_tz'])); ?></a> 
                        </div>
                        <p><?php echo nl2br(_esc($reaction['post']['post'])); ?></p>
                        <?php $res->partial('post_actions', ['post' => $reaction['post']]); ?>
                    </div>
                </div>

                <div class="depth depth_1">
                    <div class="post">
                        <div class="meta">
                            <span class="profile"><?php esc(substr($reaction['user']['username'], 0, 1)); ?></span> 
                            <span class="name"><?php esc($reaction['user']['display_name']); ?></span> 
                            @<a href="/<?php esc($reaction['user']['username']); ?>" class="username"><?php esc($reaction['user']['username']); ?></a> 
                            <a href="/<?php esc($reaction['post']['username']); ?>/<?php esc($reaction['post']['id']); ?>" class="published_at"><?php esc(elapsed($reaction['created_tz'])); ?></a> 
                        </div>
                        <p>Starred post</p>
                    </div>
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
