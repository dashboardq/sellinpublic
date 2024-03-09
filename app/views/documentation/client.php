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
                    <h2>Client</h2>
                    <p>The source code for this entire project can be found on Github here: <a href="https://github.com/dashboardq/sellinpublic">https://github.com/dashboardq/sellinpublic</a></p>
                    <p>The source code is set up so that the code can be run either as the primary server of a social network or it can be ran as a client of another server. The code is MIT licensed so feel free to make any changes to the code that you want and use it however you want.</p>
                    <p>In order to demonstrate the client functionality, there is a server set up here: <a href"https://client.sellinpublic.com">https://client.sellinpublic.com</a></p>
                    <p>This server is set up as a client of the sandbox server so all the content it displays comes from the sandbox server.</p>
                    <p>The source code at the client server has the following values set in the `.env.php` file:</p>
                    <div class="code">
                        <pre>
// API
'API_PREFIX' => 'sip_api_client_',
'API_SUFFIX' => '_key',
'API_TYPE' => 'client', // client or server
// Below items only needed if client.
'API_BASE' => 'https://sandbox.sellinpublic.com', // https://example.com
'API_VERSION' => '/api/v0', // /api/v0
'API_REMOTE_USERNAME' => 'demo',
'API_REMOTE_KEY' => 'sip_api_sand_01234demo56789_key',
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

