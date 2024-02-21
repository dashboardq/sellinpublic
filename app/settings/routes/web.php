<?php

use mavoc\core\Route;

//Route::get('/', ['MainController', 'building']);
Route::get('/', ['MainController', 'home']);
//Route::get('latest', ['MainController', 'home']);
Route::get('about', ['MainController', 'about']);
Route::get('terms', ['MainController', 'terms']);
Route::get('privacy', ['MainController', 'privacy']);

Route::get('documentation', ['DocumentationController', 'introduction']);
Route::get('documentation/authentication', ['DocumentationController', 'authentication']);
Route::get('documentation/request', ['DocumentationController', 'request']);
Route::get('documentation/response', ['DocumentationController', 'response']);
Route::get('documentation/sandbox', ['DocumentationController', 'sandbox']);
Route::get('documentation/client', ['DocumentationController', 'client']);
Route::get('documentation/cli', ['DocumentationController', 'cli']);
Route::get('documentation/changelog', ['DocumentationController', 'changelog']);
Route::get('documentation/endpoints', ['DocumentationController', 'endpoints']);
Route::get('documentation/endpoint/account', ['DocumentationController', 'account']);
Route::get('documentation/endpoint/account/get', ['DocumentationController', 'accountGet']);
Route::get('documentation/endpoint/account/update', ['DocumentationController', 'accountUpdate']);
Route::get('documentation/endpoint/metrics', ['DocumentationController', 'metrics']);
Route::get('documentation/endpoint/metrics/published', ['DocumentationController', 'metricsPublished']);
Route::get('documentation/endpoint/metrics/pending', ['DocumentationController', 'metricsPending']);
Route::get('documentation/endpoint/metrics/usernames', ['DocumentationController', 'metricsUsernames']);
Route::get('documentation/endpoint/miscellaneous', ['DocumentationController', 'miscellaneous']);
Route::get('documentation/endpoint/posts', ['DocumentationController', 'posts']);
Route::get('documentation/endpoint/posts/latest', ['DocumentationController', 'postsLatest']);
Route::get('documentation/endpoint/posts/pending', ['DocumentationController', 'postsPending']);
Route::get('documentation/endpoint/posts/create', ['DocumentationController', 'postsCreate']);
Route::get('documentation/endpoint/settings', ['DocumentationController', 'settings']);
Route::get('documentation/endpoint/settings/get', ['DocumentationController', 'settingsGet']);
Route::get('documentation/endpoint/settings/timezones', ['DocumentationController', 'settingsTimezones']);
Route::get('documentation/endpoint/settings/update', ['DocumentationController', 'settingsUpdate']);


// Private
Route::get('account', ['AccountsController', 'account'], 'private');
Route::post('account', ['AccountsController', 'update'], 'private');

Route::get('settings', ['SettingsController', 'settings'], 'private');
Route::post('settings', ['SettingsController', 'update'], 'private');

Route::get('api-keys', ['APIKeysController', 'list'], 'private');
Route::get('api-key/add', ['APIKeysController', 'add'], 'private');
Route::get('api-key/copy', ['APIKeysController', 'copy'], 'private');
Route::post('api-key/add', ['APIKeysController', 'create'], 'private');
Route::post('api-key/delete/{id}', ['APIKeysController', 'delete'], 'private');


Route::get('usernames', ['UsernameController', 'list'], 'private');
Route::get('username/add', ['UsernameController', 'add'], 'private');
Route::post('username/create', ['UsernameController', 'create'], 'private');

Route::get('post', ['PostsController', 'add'], 'private');
Route::post('post', ['PostsController', 'create'], 'private');
Route::get('pending', ['PostsController', 'pending'], 'private');

//Route::get('account', ['AuthController', 'account'], 'private');
//Route::post('account', ['AuthController', 'accountPost'], 'private');
Route::get('change-password', ['AuthController', 'changePassword'], 'private');
Route::post('change-password', ['AuthController', 'changePasswordPost'], 'private');
Route::post('logout', ['AuthController', 'logout'], 'private');


// Public
Route::get('forgot-password', ['AuthController', 'forgotPassword'], 'public');
Route::post('forgot-password', ['AuthController', 'forgotPasswordPost'], 'public');
Route::get('login', ['AuthController', 'login'], 'public');
Route::post('login', ['AuthController', 'loginPost'], 'public');
Route::post('register', ['AuthController', 'registerPost'], 'public');
Route::get('reset-password', ['AuthController', 'resetPassword'], 'public');
Route::post('reset-password', ['AuthController', 'resetPasswordPost'], 'public');


Route::get('{username}/{post_id}', ['PostsController', 'post']);
Route::get('{username}', ['ProfilesController', 'profile']); 
