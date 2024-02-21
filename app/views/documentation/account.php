<!DOCTYPE html>                
<html>
    <head>                     
        <?php $res->partial('head'); ?>
    </head>
    <body class="<?php $res->pathClass(); ?> page_documentation">
        <?php $res->partial('view_app_before'); ?>
        <div id="app" class="columns_2">
            <?php $res->partial('header'); ?>
            <?php $res->partial('sidebar_documentation'); ?> 
            <main>
                <div id="content" class="page">
                    <h2>Account</h2>
                    <p>All three of the account endpoints are private and require a Pro account.</p>
					<hr>
					<h3>GET /account</h3>
					<p>Provides details about the user account.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/account -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "user_id": 2,
    "username": "demo",
    "display_name": "Demo User",
    "bio": ""
  }
}</pre>
                    </div>
					<hr>
					<h3>POST /account</h3>
					<p>Updates the account with the information provided.</p>
                    <h4>Request body</h4>
                    <p><strong>display_name</strong>: string<br>
                    The name that is display publicly on the user profile page and with each post.</p>
                    <p><strong>bio</strong>: string<br>
                    The text info that is displayed on the user's profile.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/account -u "demo:sip_api_sand_01234demo56789_key" -d "display_name=Demo Updated"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "user_id": 2,
    "username": "demo",
    "display_name": "Demo Updated",
    "bio": ""
  }
}</pre>
                    </div>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

