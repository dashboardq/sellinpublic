
            <div id="sidebar_left" class="sidebars sidebar_profile">
                <div class="meta">
                    <span class="profile"><?php esc(substr($profile['username'], 0, 1)); ?></span> 
                    <span class="name"><?php esc($profile['display_name']); ?></span> 
                    @<a href="/<?php esc($profile['username']); ?>" class="username"><?php esc($profile['username']); ?></a> 
                </div>
                <form class="follow">
                    <button onclick="alert('Coming soon'); return false;">Follow</button>
                </form>
                <div class="bio">
                    <?php echo nl2br(_esc($profile['bio'])); ?>
                </div>
            </div>
