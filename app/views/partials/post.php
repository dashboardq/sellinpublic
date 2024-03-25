
                    <div class="post">
                        <?php $res->partial('post_meta', compact('post')); ?>
                        <p><?php echo \app\handlify(linkify(nl2br(_esc($post['post'])))); ?></p>

                        <?php foreach($post['attachments'] as $attachment): ?>
                        <?php if($attachment['type'] == 'text'): ?>
                        <div class="attachment attachment_text shown">
                            <button class="show">Show Additional Text</button>
                            <button class="hide">Hide Additional Text</button>
                            <p><?php echo \app\handlify(linkify(nl2br(_esc($attachment['content'])))); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>

                        <?php if(!isset($show_actions) || $show_actions): ?>
                        <?php $res->partial('post_actions', compact('post')); ?>
                        <?php endif; ?>
                    </div>
