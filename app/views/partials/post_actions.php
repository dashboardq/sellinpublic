                    <div class="actions">
                        <span>
                            <?php if($post['replied']): ?>
                            <a href="/post/<?php esc($post['id']); ?>/reply" class="reply"><img src="/mavoc/images/tabler-icons/message-circle-2-filled.svg" alt="Comments Icon" /></a> 
                            <?php else: ?>
                            <a href="/post/<?php esc($post['id']); ?>/reply" class="reply"><img src="/mavoc/images/tabler-icons/message-circle-2.svg" alt="Comments Icon" /></a> 
                            <?php endif; ?>
                            <a href="/<?php esc($post['username']); ?>/<?php esc($post['id']); ?>" data-value="<?php esc($post['replies']); ?>"><?php esc($post['replies']); ?></a>
                        </span>
                        <?php /*
                        <span>
                            <a href="#" class="repost"><img src="/mavoc/images/tabler-icons/repeat.svg" alt="Repost Icon" /></a>
                            <a href="/<?php esc($post['username']); ?>/<?php esc($post['id']); ?>/reposts" data-value="<?php esc($post['reposts']); ?>"><?php esc($post['reposts']); ?></a>
                        </span>
                        <span>
                            <a href="#" class="quote"><img src="/mavoc/images/modified-icons/quote-filled.svg" alt="Quote Icon" /></a>
                            <a href="/<?php esc($post['username']); ?>/<?php esc($post['id']); ?>/quotes" data-value="<?php esc($post['quotes']); ?>"><?php esc($post['quotes']); ?></a>
                        </span>
                         */ ?>
                         <span class="group <?php echo $post['starred'] ? 'starred' : 'unstarred'; ?>">
                            <a href="/unstar/<?php esc($post['id']); ?>" class="unstar"><img src="/mavoc/images/tabler-icons/star-filled.svg" alt="Star Icon" /></a>
                            <a href="/star/<?php esc($post['id']); ?>" class="star"><img src="/mavoc/images/tabler-icons/star.svg" alt="Star Icon" /></a>
                            <a href="/<?php esc($post['username']); ?>/<?php esc($post['id']); ?>/stars" data-value="<?php esc($post['stars']); ?>"><?php esc($post['stars']); ?></a>
                        </span>

                         <span class="group <?php echo $post['flagged'] ? 'flagged' : 'unflagged'; ?>">
                            <a href="/unflag/<?php esc($post['id']); ?>" class="unflag"><img src="/mavoc/images/tabler-icons/flag-filled.svg" alt="Flag Icon" /></a>
                            <a href="/flag/<?php esc($post['id']); ?>" class="flag"><img src="/mavoc/images/tabler-icons/flag.svg" alt="Flag Icon" /></a>
                         </span>
                    </div>
