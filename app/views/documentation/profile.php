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
                    <h2>Profile</h2>
                    <p>The profile endpoint is public and does not require a Pro account.</p>

					<hr>
					<h3>GET /profile/{username}</h3>
					<p>Public endpoint. Provides details about the user account.</p>

                    <h4>URL params</h4>
                    <p><strong>username</strong>: string<br>
                    The username for the account.</p>

                    <h4>Endpoint Example</h4>
					<p>Below is a live example that can be copy and pasted.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/profile/sandbox -u "demo:sip_api_sand_01234demo56789_key"</code>
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
    "username": "sandbox",
    "display_name": "Sandbox",
    "bio": ""
  }
}
</pre>
                    </div>
                </div>
            </main>
            <?php $res->partial('footer'); ?>
        </div>
        <?php $res->partial('view_app_after'); ?>
		<?php $res->partial('foot'); ?>
    </body>
</html>

