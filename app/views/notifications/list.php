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
                    <h2>Notifications</h2>
                    <?php $res->html->messages(); ?>
                    <form class="mark_all_read" action="/ajax/notifications/read" method="POST">
                        <button>Mark All As Read</button>
                    </form>
                </div>

                <?php foreach($notifications as $notification): ?>
                    <?php if($notification['type'] == 'flag'): ?>
                    <div id="notification_<?php esc($notification['id']); ?>" class="notification <?php esc($notification['status']); ?>">
                        <div class="post flag">
                            <div class="meta">
                                <a href="/<?php esc($notification['receiver_post']['username']); ?>/<?php esc($notification['receiver_post']['id']); ?>" class="published_at"><?php esc(elapsed($notification['created_tz'])); ?></a> 
                            </div>
                            <p>A user flagged this post.</p>
                            <form class="mark_read" action="/ajax/notification/read/<?php esc($notification['id']); ?>" method="POST">
                                <button>Mark As Read</button>
                            </form>
                            <form class="mark_unread" action="/ajax/notification/unread/<?php esc($notification['id']); ?>" method="POST">
                                <button>Mark As Unread</button>
                            </form>
                        </div>
                        <div class="depth depth_1">
                            <?php $res->partial('post', ['post' => $notification['receiver_post']]); ?>
                        </div>
                    </div>
                    <?php elseif($notification['type'] == 'star'): ?>
                    <div id="notification_<?php esc($notification['id']); ?>" class="notification <?php esc($notification['status']); ?>">
                        <div class="post">
                            <div class="meta">
                                <span class="profile"><img src="<?php esc($notification['initiator']['profile_image_url']); ?>" alt="Profile image" /></span> 
                                <span class="name"><?php esc($notification['initiator']['display_name']); ?></span> 
                                @<a href="/<?php esc($notification['initiator']['username']); ?>" class="username"><?php esc($notification['initiator']['username']); ?></a> 
                                <a href="/<?php esc($notification['initiator']['username']); ?>/<?php esc($notification['initiator']['id']); ?>" class="published_at"><?php esc(elapsed($notification['created_tz'])); ?></a> 
                            </div>
                            <p>Starred your post.</p>
                            <form class="mark_read" action="/ajax/notification/read/<?php esc($notification['id']); ?>" method="POST">
                                <button>Mark As Read</button>
                            </form>
                            <form class="mark_unread" action="/ajax/notification/unread/<?php esc($notification['id']); ?>" method="POST">
                                <button>Mark As Unread</button>
                            </form>
                        </div>
                        <div class="depth depth_1">
                            <?php $res->partial('post', ['post' => $notification['receiver_post']]); ?>
                        </div>
                    </div>
                    <?php elseif($notification['type'] == 'reply'): ?>
                    <div id="notification_<?php esc($notification['id']); ?>" class="notification <?php esc($notification['status']); ?>">
                        <div class="post">
                            <div class="meta">
                                <span class="profile"><img src="<?php esc($notification['initiator']['profile_image_url']); ?>" alt="Profile image" /></span> 
                                <span class="name"><?php esc($notification['initiator']['display_name']); ?></span> 
                                @<a href="/<?php esc($notification['initiator']['username']); ?>" class="username"><?php esc($notification['initiator']['username']); ?></a> 
                                <a href="/<?php esc($notification['initiator']['username']); ?>/<?php esc($notification['initiator_post']['id']); ?>" class="published_at"><?php esc(elapsed($notification['created_tz'])); ?></a> 
                            </div>
                            <p>Replied to your post.</p>
                            <form class="mark_read" action="/ajax/notification/read/<?php esc($notification['id']); ?>" method="POST">
                                <button>Mark As Read</button>
                            </form>
                            <form class="mark_unread" action="/ajax/notification/unread/<?php esc($notification['id']); ?>" method="POST">
                                <button>Mark As Unread</button>
                            </form>
                        </div>
                        <div class="depth depth_1">
                            <?php $res->partial('post', ['post' => $notification['receiver_post']]); ?>
                        </div>
                        <div class="depth depth_2">
                            <?php $res->partial('post', ['post' => $notification['initiator_post']]); ?>
                        </div>
                    </div>
                    <?php endif; ?>
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

