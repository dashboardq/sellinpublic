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

                    <?php if(ao()->env('APP_LOGIN_TYPE') == 'db'): ?>
                        <?php $res->html->messages(); ?>
                        <form method="POST">
                            <?php $res->html->text('Username', 'username', '', '', 'disabled'); ?>

                            <?php $res->html->text('Email', 'email'); ?>
                            
                            <?php $res->html->text('Full Name', 'name'); ?>

                            <?php $res->html->text('Display Name', 'display_name'); ?>

                            <?php $res->html->textarea('Bio', 'bio'); ?>
                            <p>240 characters max</p>

                            <?php $res->html->submit('Update'); ?>
                        </form>
                    <?php else: ?>
                        <form method="POST">
                            <?php $res->html->text('Username', 'username', '', '', 'disabled'); ?>

                            <?php $res->html->text('Email', 'email', '', '', 'disabled'); ?>

                            <?php $res->html->text('Full Name', 'name', '', '', 'disabled'); ?>

                            <?php $res->html->text('Display Name', 'display_name'); ?>

                            <?php $res->html->textarea('Bio', 'bio'); ?>
                            <p>240 characters max</p>

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

