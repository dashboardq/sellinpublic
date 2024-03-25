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
                <?php /*
                <div class="page">
                    <h1>Latest</h1>
                    <?php $res->partial('view_notice_before'); ?>
                    <div class="notice">
                        <p>Sell In Public is currently being built (March 2024) and is currently in an alpha state. There are more changes and updates still to come.</p>
                    </div>
                    <?php $res->partial('view_notice_after'); ?>

                    <?php $res->html->messages(); ?>
                </div>
                 */ ?>
                <?php $res->html->messages(); ?>

                <?php foreach($posts as $post): ?>
                <?php $res->partial('post', ['post' => $post]); ?>
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
