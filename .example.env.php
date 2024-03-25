<?php

// These are permanent values that should not be overwritten during execution.
// If you need configuration values that can be potentially changed, use the .conf.php file.
// These are typically uppercase to emphasize their permanence.

if(is_file(__DIR__ . DIRECTORY_SEPARATOR . '.keys.php')) {
    $keys = require __DIR__ . DIRECTORY_SEPARATOR . '.keys.php';
} else {
    $keys = [];
}

// No closing slash on the directories or urls.
return [
    // App
    'APP_NAME' => 'Example', 
    'APP_ENV' => 'dev',
    'APP_DEBUG' => false, // Loads the Debug.php file
    'APP_HOST' => 'www.example.com',
    'APP_SITE' => 'https://www.example.com',
    // Author information used on Terms and Privacy pages.
    'APP_AUTHOR' => 'Organization', 
    'APP_AUTHOR_EMAIL' => 'support@example.com', 
    'APP_AUTHOR_ADDRESS' => "123 Main Street\nNashville, TN 37203", 
    // Terms and Privacy info
    'APP_PRIVACY_UPDATED' => 'July 15, 2022',
    'APP_TERMS_UPDATED' => 'July 15, 2022',
    'APP_DESCRIPTION' => 'A simple social network app.', 

	// The 'list' option is only used for simple, non-database sites.
    'APP_LOGIN_TYPE' => 'db', // Options: none, list, db (or options from other plugins)
    // If 'list' is chosen, these users will be available for login. The number is the user_id.
    'APP_LOGIN_USERS' => [
        1 => ['email' => 'user@example.com', 'password' => 'example'],
    ],  
    // APP_LOGIN needs to be 'db' in order for true to turn on registrations.
    'APP_REGISTER_ALLOW' => true,

    // How long the session cookie should be saved. Note this can also be affected by the
    // PHP session.gc_maxlifetime configuration.
    'APP_SESSION_SECONDS' => 60 * 60 * 24 * 30,

    'APP_PRIVATE_HOME' => '/account',
    'APP_PUBLIC_HOME' => '/login',
    'APP_ANALYTICS' => '<script></script>', 

    'APP_KEYS' => $keys, 

    'APP_USER_DOMAIN' => '', // On production site, this is set to '.sip.name'. Set it to '' if you do not want to use a default domain.

    // Mavoc
    'AO_MAINTENANCE' => false, // Set to true will show the maintenance page.
    'AO_MAINTENANCE_EXCLUDE' => ['256.256.0.1'], // Enter a valid IP address that should be able to skip the maintenance page.
    'AO_MAINTENANCE_STARTED' => '2022-07-15 10:00:00 UTC', 
    'AO_MAINTENANCE_ENDING' => '2022-07-15 11:00:00 UTC', // Use a datetime
    'AO_MAINTENANCE_ENDING' => '2 hours', // Or use a relative value
    'AO_MAINTENANCE_VIEW' => 'alt/maintenance', // Location of the maintenance view file

    'AO_APP_DIR' => __DIR__ . DIRECTORY_SEPARATOR . 'app',
    'AO_BASE_DIR' => __DIR__,
    'AO_DB_DIR' => __DIR__ . DIRECTORY_SEPARATOR . 'db',
    'AO_PLUGIN_DIR' => __DIR__ . DIRECTORY_SEPARATOR . 'plugins',
    'AO_PUBLIC_DIR' => __DIR__ . DIRECTORY_SEPARATOR . 'public',
    'AO_SETTINGS_DIR' => __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'settings',
    'AO_STORAGE_DIR' => __DIR__ . DIRECTORY_SEPARATOR . '.storage',
    'AO_MAVOC_DIR' => __DIR__ . DIRECTORY_SEPARATOR . 'mavoc',
    'AO_MAVOC_CONSOLE_DIR' => __DIR__ . DIRECTORY_SEPARATOR . 'mavoc' . DIRECTORY_SEPARATOR . 'console',
    'AO_MAVOC_CORE_DIR' => __DIR__ . DIRECTORY_SEPARATOR . 'mavoc' . DIRECTORY_SEPARATOR . 'core',

    // Set the permissions (used in script automations like: php ao process)
    'AO_CHOWN' => '', // Your username
    'AO_CHGRP' => '', // Your group (like www-data)
    'AO_CHMOD_FILE' => 0664,
    'AO_CHMOD_DIR' => 0775,

    'AO_OUTPUT_HOOKS' => false,

    // DB
    'DB_USE' => false,
    'DB_INSTALL' => true, // This is used to run the migrations on the initial load. If you are using the command line, set this to false.
    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'example_com',
    'DB_USER' => 'example_com',
    'DB_PASS' => '',
    'DB_CHARSET' => 'utf8mb4',

    // API
    'API_PREFIX' => 'sip_api_demo_',
    'API_SUFFIX' => '_key',
    'API_TYPE' => 'server', // client or server
    // Below items only needed if client.
    'API_BASE' => 'https://example.com', // https://example.com
    'API_VERSION' => '/api/v0', // /api/v0
    'API_REMOTE_USERNAME' => 'demo',
    'API_REMOTE_KEY' => 'sip_api_example_key',

    // Email
    'EMAIL_ADMIN' => 'admin@example.com',
    'EMAIL_FROM' => 'Sender Name <sender@example.com>',
    'EMAIL_SEND' => false, // null pretends to send, true sends, false errors and does not send
    'EMAIL_OVERRIDE_TO' => false, // if set to an email address and EMAIL_SEND is true, all emails generated by the app will only be sent to this email address

    // OAuth Services
    'SERVICE_URL' => 'https://api.example.net',
    'SERVICE_URL_AUTHORIZE' => 'https://service.example.net/login/oauth/authorize',
    'SERVICE_URL_REDIRECT' => 'http://example.com/oauth/redirect',
    'SERVICE_URL_TOKEN' => 'https://service.example.net/login/oauth/access_token',
    'SERVICE_CLIENT_ID' => 'api_id',
    'SERVICE_CLIENT_SECRET' => 'api_secret',
    'SERVICE_USER_AGENT' => 'some_services_require_this_item', 

    // Rsync
    'RSYNC_SERVERS' => [
        'prod' => 'user@example.com:/var/www/example.com',
    ],
];

