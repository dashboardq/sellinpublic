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
                    <h2>Account</h2>

                    <?php $res->html->messages(); ?>
                    <div class="profile">
                        <label>Profile Image</label>
                        <img src="<?php esc($profile_image_url); ?>" alt="Profile Image" />
                        <label class="button">
Upload New Image
                        <input class="file" type="file" accept=".jpg,.jpeg,.png" />
</label>
                        <span>Recommended dimensions: 400x400</span>
                    </div>

                    <?php if(ao()->env('APP_LOGIN_TYPE') == 'db'): ?>
                        <form method="POST">
                            <?php $res->html->hidden('media_id'); ?>

                            <?php $res->html->text('Username', 'username', '', '', 'disabled'); ?>

                            <?php $res->html->text('Email', 'email'); ?>
                            
                            <?php $res->html->text('Full Name', 'name'); ?>

                            <?php $res->html->text('Display Name', 'display_name'); ?>

                            <?php $res->html->textarea('Bio', 'bio', '', '', 'id="bio"'); ?>
                            <?php if(isset($fields['bio']) && strlen($fields['bio'])): ?>
                                <p data-max="240" data-watch="#bio">240 characters max / <?php esc(240 - strlen($fields['bio'])); ?> characters remaining</p>
                            <?php else: ?>
                            <p data-max="240" data-watch="#bio">240 characters max</p>
                            <?php endif; ?>

                            <?php $res->html->submit('Update'); ?>
                        </form>
                    <?php else: ?>
                        <form method="POST">
                            <?php $res->html->hidden('media_id'); ?>

                            <?php $res->html->text('Username', 'username', '', '', 'disabled'); ?>

                            <?php $res->html->text('Email', 'email', '', '', 'disabled'); ?>

                            <?php $res->html->text('Full Name', 'name', '', '', 'disabled'); ?>

                            <?php $res->html->text('Display Name', 'display_name'); ?>

                            <?php $res->html->textarea('Bio', 'bio', '', '', 'id="bio"'); ?>
                            <?php if(isset($fields['bio']) && strlen($fields['bio'])): ?>
                                <p data-max="240" data-watch="#bio">240 characters max / <?php esc(240 - strlen($fields['bio'])); ?> characters remaining</p>
                            <?php else: ?>
                            <p data-max="240" data-watch="#bio">240 characters max</p>
                            <?php endif; ?>

                            <?php $res->html->submit('Update'); ?>
                        </form>
                    <?php endif; ?>

                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

