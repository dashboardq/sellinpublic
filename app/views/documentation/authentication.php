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
                    <h2>Authentication</h2>
                    <p>Authentication is handled by passing your username and an API key to the endpoint using Basic Authentication.</p>
                    <p>An API key can be created by going to the <a href="/api-keys">API Keys</a> page in your account.</p>
                    <p>Below is an example using cURL on the sandbox server using the `demo` user and the demo API key. This is a live example that you can copy and paste in your terminal.</p>
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

