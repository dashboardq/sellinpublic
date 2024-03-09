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
                        <div class="depth depth_0">
                            <div class="post">
                                <div class="meta">
                                    <span class="profile"><?php esc(substr($notification['receiver_post']['username'], 0, 1)); ?></span> 
                                    <span class="name"><?php esc($notification['receiver_post']['display_name']); ?></span> 
                                    @<a href="/<?php esc($notification['receiver_post']['username']); ?>" class="username"><?php esc($notification['receiver_post']['username']); ?></a> 
                                    <a href="/<?php esc($notification['receiver_post']['username']); ?>/<?php esc($notification['receiver_post']['id']); ?>" class="published_at"><?php esc(elapsed($notification['receiver_post']['published_tz'])); ?></a> 
                                </div>
                                <p><?php echo nl2br(_esc($notification['receiver_post']['post'])); ?></p>
                                <div class="actions">
                                    <a href="/reply/<?php esc($notification['receiver_post']['id']); ?>" class="reply"><img src="/mavoc/images/tabler-icons/message-circle-2.svg" alt="Comments Icon" /> <span data-value="<?php esc($notification['receiver_post']['replies']); ?>"><?php esc($notification['receiver_post']['replies']); ?></span></a>
                                    <a href="#" class="repost"><img src="/mavoc/images/tabler-icons/repeat.svg" alt="Repost Icon" /> <span data-value="<?php esc($notification['receiver_post']['reposts']); ?>"><?php esc($notification['receiver_post']['reposts']); ?></span></a>
                                    <a href="#" class="quote"><img src="/mavoc/images/modified-icons/quote-filled.svg" alt="Quote Icon" /> <span data-value="<?php esc($notification['receiver_post']['quotes']); ?>"><?php esc($notification['receiver_post']['quotes']); ?></span></a>
                                    <a href="#" class="star"><img src="/mavoc/images/tabler-icons/star.svg" alt="Star Icon" /> <span data-value="<?php esc($notification['receiver_post']['stars']); ?>"><?php esc($notification['receiver_post']['stars']); ?></span></a>
                                    <a href="#" class="flag"><img src="/mavoc/images/tabler-icons/flag.svg" alt="Flag Icon" /></a>
                                </div>
                            </div>
                        </div>
                        <?php /*
                        <div class="post">
                            <div class="meta">
                                <span class="profile"><?php esc(substr($notification['initiator']['username'], 0, 1)); ?></span> 
                                <span class="name"><?php esc($notification['initiator']['display_name']); ?></span> 
                                @<a href="/<?php esc($notification['initiator']['username']); ?>" class="username"><?php esc($notification['initiator']['username']); ?></a> 
                                <a href="/<?php esc($notification['initiator']['username']); ?>/<?php esc($notification['initiator']['id']); ?>" class="published_at"><?php esc(elapsed($notification['created_tz'])); ?></a> 
                            </div>
                            <p>Replied to your post.</p>
                            <?php if($notification['status'] == 'unread'): ?>
                            <button>Mark As Read</button>
                            <?php endif; ?>
                        </div>
                         */ ?>
                    </div>
                    <?php elseif($notification['type'] == 'star'): ?>
                    <div id="notification_<?php esc($notification['id']); ?>" class="notification <?php esc($notification['status']); ?>">
                        <div class="post">
                            <div class="meta">
                                <span class="profile"><?php esc(substr($notification['initiator']['username'], 0, 1)); ?></span> 
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
                        <?php /*
                        <div class="page">
                            <?php esc($notification['created_tz']->format('Y-m-d G:i T')); ?>
                        </div>
                         */ ?>
                        <div class="depth depth_0">
                            <div class="post">
                                <div class="meta">
                                    <span class="profile"><?php esc(substr($notification['receiver_post']['username'], 0, 1)); ?></span> 
                                    <span class="name"><?php esc($notification['receiver_post']['display_name']); ?></span> 
                                    @<a href="/<?php esc($notification['receiver_post']['username']); ?>" class="username"><?php esc($notification['receiver_post']['username']); ?></a> 
                                    <a href="/<?php esc($notification['receiver_post']['username']); ?>/<?php esc($notification['receiver_post']['id']); ?>" class="published_at"><?php esc(elapsed($notification['receiver_post']['published_tz'])); ?></a> 
                                </div>
                                <p><?php echo nl2br(_esc($notification['receiver_post']['post'])); ?></p>
                                <div class="actions">
                                    <a href="/reply/<?php esc($notification['receiver_post']['id']); ?>" class="reply"><img src="/mavoc/images/tabler-icons/message-circle-2.svg" alt="Comments Icon" /> <span data-value="<?php esc($notification['receiver_post']['replies']); ?>"><?php esc($notification['receiver_post']['replies']); ?></span></a>
                                    <a href="#" class="repost"><img src="/mavoc/images/tabler-icons/repeat.svg" alt="Repost Icon" /> <span data-value="<?php esc($notification['receiver_post']['reposts']); ?>"><?php esc($notification['receiver_post']['reposts']); ?></span></a>
                                    <a href="#" class="quote"><img src="/mavoc/images/modified-icons/quote-filled.svg" alt="Quote Icon" /> <span data-value="<?php esc($notification['receiver_post']['quotes']); ?>"><?php esc($notification['receiver_post']['quotes']); ?></span></a>
                                    <a href="#" class="star"><img src="/mavoc/images/tabler-icons/star.svg" alt="Star Icon" /> <span data-value="<?php esc($notification['receiver_post']['stars']); ?>"><?php esc($notification['receiver_post']['stars']); ?></span></a>
                                    <a href="#" class="flag"><img src="/mavoc/images/tabler-icons/flag.svg" alt="Flag Icon" /></a>
                                </div>
                            </div>
                        </div>
                        <?php /*
                        <div class="post">
                            <div class="meta">
                                <span class="profile"><?php esc(substr($notification['initiator']['username'], 0, 1)); ?></span> 
                                <span class="name"><?php esc($notification['initiator']['display_name']); ?></span> 
                                @<a href="/<?php esc($notification['initiator']['username']); ?>" class="username"><?php esc($notification['initiator']['username']); ?></a> 
                                <a href="/<?php esc($notification['initiator']['username']); ?>/<?php esc($notification['initiator']['id']); ?>" class="published_at"><?php esc(elapsed($notification['created_tz'])); ?></a> 
                            </div>
                            <p>Replied to your post.</p>
                            <?php if($notification['status'] == 'unread'): ?>
                            <button>Mark As Read</button>
                            <?php endif; ?>
                        </div>
                         */ ?>
                    </div>
                    <?php elseif($notification['type'] == 'reply'): ?>
                    <div id="notification_<?php esc($notification['id']); ?>" class="notification <?php esc($notification['status']); ?>">
                        <div class="post">
                            <div class="meta">
                                <span class="profile"><?php esc(substr($notification['initiator']['username'], 0, 1)); ?></span> 
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
                        <?php /*
                        <div class="page">
                            <?php esc($notification['created_tz']->format('Y-m-d G:i T')); ?>
                        </div>
                         */ ?>
                        <div class="depth depth_0">
                            <div class="post">
                                <div class="meta">
                                    <span class="profile"><?php esc(substr($notification['receiver_post']['username'], 0, 1)); ?></span> 
                                    <span class="name"><?php esc($notification['receiver_post']['display_name']); ?></span> 
                                    @<a href="/<?php esc($notification['receiver_post']['username']); ?>" class="username"><?php esc($notification['receiver_post']['username']); ?></a> 
                                    <a href="/<?php esc($notification['receiver_post']['username']); ?>/<?php esc($notification['receiver_post']['id']); ?>" class="published_at"><?php esc(elapsed($notification['receiver_post']['published_tz'])); ?></a> 
                                </div>
                                <p><?php echo nl2br(_esc($notification['receiver_post']['post'])); ?></p>
                                <div class="actions">
                                    <a href="/reply/<?php esc($notification['receiver_post']['id']); ?>" class="reply"><img src="/mavoc/images/tabler-icons/message-circle-2.svg" alt="Comments Icon" /> <span data-value="<?php esc($notification['receiver_post']['replies']); ?>"><?php esc($notification['receiver_post']['replies']); ?></span></a>
                                    <a href="#" class="repost"><img src="/mavoc/images/tabler-icons/repeat.svg" alt="Repost Icon" /> <span data-value="<?php esc($notification['receiver_post']['reposts']); ?>"><?php esc($notification['receiver_post']['reposts']); ?></span></a>
                                    <a href="#" class="quote"><img src="/mavoc/images/modified-icons/quote-filled.svg" alt="Quote Icon" /> <span data-value="<?php esc($notification['receiver_post']['quotes']); ?>"><?php esc($notification['receiver_post']['quotes']); ?></span></a>
                                    <a href="#" class="star"><img src="/mavoc/images/tabler-icons/star.svg" alt="Star Icon" /> <span data-value="<?php esc($notification['receiver_post']['stars']); ?>"><?php esc($notification['receiver_post']['stars']); ?></span></a>
                                    <a href="#" class="flag"><img src="/mavoc/images/tabler-icons/flag.svg" alt="Flag Icon" /></a>
                                </div>
                            </div>
                        </div>
                        <div class="depth depth_1">
                            <div class="post">
                                <div class="meta">
                                    <span class="profile"><?php esc(substr($notification['initiator_post']['username'], 0, 1)); ?></span> 
                                    <span class="name"><?php esc($notification['initiator_post']['display_name']); ?></span> 
                                    @<a href="/<?php esc($notification['initiator_post']['username']); ?>" class="username"><?php esc($notification['initiator_post']['username']); ?></a> 
                                    <a href="/<?php esc($notification['initiator_post']['username']); ?>/<?php esc($notification['initiator_post']['id']); ?>" class="published_at"><?php esc(elapsed($notification['initiator_post']['published_tz'])); ?></a> 
                                </div>
                                <p><?php echo nl2br(_esc($notification['initiator_post']['post'])); ?></p>
                                <div class="actions">
                                    <a href="/reply/<?php esc($notification['initiator_post']['id']); ?>" class="reply"><img src="/mavoc/images/tabler-icons/message-circle-2.svg" alt="Comments Icon" /> <span data-value="<?php esc($notification['initiator_post']['replies']); ?>"><?php esc($notification['initiator_post']['replies']); ?></span></a>
                                    <a href="#" class="repost"><img src="/mavoc/images/tabler-icons/repeat.svg" alt="Repost Icon" /> <span data-value="<?php esc($notification['initiator_post']['reposts']); ?>"><?php esc($notification['initiator_post']['reposts']); ?></span></a>
                                    <a href="#" class="quote"><img src="/mavoc/images/modified-icons/quote-filled.svg" alt="Quote Icon" /> <span data-value="<?php esc($notification['initiator_post']['quotes']); ?>"><?php esc($notification['initiator_post']['quotes']); ?></span></a>
                                    <a href="#" class="star"><img src="/mavoc/images/tabler-icons/star.svg" alt="Star Icon" /> <span data-value="<?php esc($notification['initiator_post']['stars']); ?>"><?php esc($notification['initiator_post']['stars']); ?></span></a>
                                    <a href="#" class="flag"><img src="/mavoc/images/tabler-icons/flag.svg" alt="Flag Icon" /></a>
                                </div>
                            </div>
                        </div>
                        <?php /*
                        <div class="post">
                            <div class="meta">
                                <span class="profile"><?php esc(substr($notification['initiator']['username'], 0, 1)); ?></span> 
                                <span class="name"><?php esc($notification['initiator']['display_name']); ?></span> 
                                @<a href="/<?php esc($notification['initiator']['username']); ?>" class="username"><?php esc($notification['initiator']['username']); ?></a> 
                                <a href="/<?php esc($notification['initiator']['username']); ?>/<?php esc($notification['initiator']['id']); ?>" class="published_at"><?php esc(elapsed($notification['created_tz'])); ?></a> 
                            </div>
                            <p>Replied to your post.</p>
                            <?php if($notification['status'] == 'unread'): ?>
                            <button>Mark As Read</button>
                            <?php endif; ?>
                        </div>
                         */ ?>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if($pagination): ?>
                <div class="pagination">
                    <p>Results <?php esc($pagination['current_result'] . '-' . $pagination['current_result_last'] . ' of ' . $pagination['total_results']); ?> <?php if($pagination['page_previous'] != $pagination['page_current']): ?>&lt; <a href="<?php esc($pagination['url_previous']); ?>">Prev</a><?php endif; ?> <?php if($pagination['page_next'] != $pagination['page_current']): ?><a href="<?php esc($pagination['url_next']); ?>">Next</a> &gt;<?php endif; ?></p>
                </div>
                <?php endif; ?>

                <?php /*
                <div class="depth depth_<?php esc($post['depth']); ?>">
                    <div class="post">
                        <div class="meta">
                            <span class="profile"><?php esc(substr($post['username'], 0, 1)); ?></span> 
                            <span class="name"><?php esc($post['display_name']); ?></span> 
                            @<a href="/<?php esc($post['username']); ?>" class="username"><?php esc($post['username']); ?></a> 
                            <a href="/<?php esc($post['username']); ?>/<?php esc($post['id']); ?>" class="published_at"><?php esc(elapsed($post['published_tz'])); ?></a> 
                        </div>
                        <p><?php echo nl2br(_esc($post['post'])); ?></p>
                        <div class="actions">
                            <a href="/reply/<?php esc($post['id']); ?>" class="reply"><img src="/mavoc/images/tabler-icons/message-circle-2.svg" alt="Comments Icon" /> <span data-value="<?php esc($post['replies']); ?>"><?php esc($post['replies']); ?></span></a>
                            <a href="#" class="repost"><img src="/mavoc/images/tabler-icons/repeat.svg" alt="Repost Icon" /> <span data-value="<?php esc($post['reposts']); ?>"><?php esc($post['reposts']); ?></span></a>
                            <a href="#" class="quote"><img src="/mavoc/images/modified-icons/quote-filled.svg" alt="Quote Icon" /> <span data-value="<?php esc($post['quotes']); ?>"><?php esc($post['quotes']); ?></span></a>
                            <a href="#" class="star"><img src="/mavoc/images/tabler-icons/star.svg" alt="Star Icon" /> <span data-value="<?php esc($post['stars']); ?>"><?php esc($post['stars']); ?></span></a>
                            <a href="#" class="flag"><img src="/mavoc/images/tabler-icons/flag.svg" alt="Flag Icon" /></a>
                        </div>
                    </div>
                </div>
                 */ ?>

            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

