
            <div id="sidebar_left" class="sidebars sidebar_profile">
                <div class="meta">
                    <span class="profile"><img src="<?php esc($profile['profile_image_url']); ?>" alt="Profile image" /></span> 
                    <span class="name"><?php esc($profile['display_name']); ?></span> 
                    @<a href="/<?php esc($profile['username']); ?>" class="username"><?php esc($profile['username']); ?></a> 
                </div>
                <form class="follow">
                    <button onclick="alert('Coming soon'); return false;">Follow</button>
                </form>
                <div class="bio">
                    <p><?php echo \app\handlify(linkify(nl2br(_esc($profile['bio'])))); ?></p>
                </div>
            </div>
