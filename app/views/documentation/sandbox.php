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
                    <h2>Sandbox</h2>
                    <p>The Sandbox server is used for testing. It is automatically regenerated every 24 hours.</p>
                    <p>The Sandbox server can be found here: <a href="https://sandbox.sellinpublic.com">https://sandbox.sellinpublic.com</a></p>
                    <p>Every account you see there can be logged in using this format:<br>
Email: <strong>[USERNAME]@example.com</strong><br>
Password: <strong>password</strong><br>
</p>
                    <p>For example, to login with the demo account, you would use this info:<br>
Email: <strong>demo@example.com</strong><br>
Password: <strong>password</strong><br>
</p>
                    <p>To login with the sandbox account, you would use this info:<br>
Email: <strong>sandbox@example.com</strong><br>
Password: <strong>password</strong><br>
</p>
                    <p>The Change Password functionality is disabled on the Sandbox server so these logins should always work.</p>
                    <p>The demo user has an API key that anyone can use on the Sandbox server:<br>
Username: <strong>demo</strong><br>
API Key: <strong>sip_api_sand_01234demo56789_key</strong>
</p>
                    <p>Below is a live example of a GET request that you can copy and paste.</p>
                    <div class="code">
                        <code>curl https://sandbox.sellinpublic.com/api/v0/hello -u "demo:sip_api_sand_01234demo56789_key"</code>
                    </div>

                    <p>Below is the expected result from that cURL call:</p>
                    <div class="code">
                        <pre>
{
  "status": "success",
  "messages": [],
  "meta": {},
  "data": {
    "name": "World"
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

