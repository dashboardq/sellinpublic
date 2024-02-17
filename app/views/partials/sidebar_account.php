
            <div id="sidebar_left" class="sidebars">
                <menu>
                    <li><a href="/account">Account</a></li>
                    <?php if(ao()->env('APP_LOGIN_TYPE') == 'db'): ?>
                    <li><a href="/change-password">Change Password</a></li>
                    <?php endif; ?>
<?php /*
                    <li><a href="/USERNAME">Profile</a></li>
 */ ?>
                    <li><a href="/pending">Pending</a></li>
                    <li><a href="/api-keys">API Keys</a></li>
                    <li><a href="/settings">Settings</a></li>
                </menu>
            </div>
