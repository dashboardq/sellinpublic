<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>
    </head>
    <body class="<?php $res->pathClass(); ?>">
        <?php $res->partial('view_app_before'); ?>
        <div id="app" class="columns_2">
            <?php $res->partial('header'); ?>
            <?php $res->partial('sidebar_profile'); ?> 
            <main>
                <div class="page">
                    <h2>Profile</h2>
                    <p>Coming soon.</p>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

