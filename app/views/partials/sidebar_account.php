
            <div id="sidebar_left" class="sidebars">
                <menu>
                    <?php $res->partial('view_sidebar_account_start'); ?>
                    <?php if($notification_count): ?>
                        <li><a href="/notifications">Notifications</a> <span class="notification_count" data-count="<?php esc($notification_count); ?>">(<?php esc($notification_count); ?>)</span></li>
                    <?php else: ?>
                    <li><a href="/notifications">Notifications</a> <span class="notification_count" data-count="0">(0)</span></li></li>
                    <?php endif; ?>
                    <li><a href="/account">Account</a></li>
                    <?php if(ao()->env('APP_LOGIN_TYPE') == 'db'): ?>
                    <li><a href="/change-password">Change Password</a></li>
                    <?php endif; ?>
<?php /*
                    <li><a href="/USERNAME">Profile</a></li>
 */ ?>
                    <li><a href="/pending">Pending</a></li>
                    <li><a href="/stars">Stars</a></li>
                    <li><a href="/api-keys">API Keys</a></li>
                    <li><a href="/settings">Settings</a></li>
                    <?php $res->partial('view_sidebar_account_end'); ?>
                </menu>
            </div>
