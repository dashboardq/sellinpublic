
                        <div class="meta">
                            <span class="profile"><img src="<?php esc($post['user']['profile_image_url']); ?>" alt="Profile image" /></span> 
                            <span class="name"><?php esc($post['user']['display_name']); ?></span> 
                            @<a href="/<?php esc($post['user']['username']); ?>" class="username"><?php esc($post['user']['username']); ?></a> 
                            <a href="/<?php esc($post['user']['username']); ?>/<?php esc($post['id']); ?>" class="published_at"><?php esc(elapsed($post['published_tz'])); ?></a> 
                        </div>
