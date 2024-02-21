<?php

use mavoc\core\Route;

Route::get('api/metric/posts', ['APIMetricsController', 'originalPosts']);
Route::get('api/metric/pendings', ['APIMetricsController', 'originalPendings']);
Route::get('api/metric/usernames', ['APIMetricsController', 'originalUsernames']);



// Public
Route::get('api/v0/hello', ['APIMiscController', 'hello']);
Route::post('api/v0/hello', ['APIMiscController', 'helloPost']);
Route::get('api/v0/latest', ['APIPostsController', 'latest']);

Route::get('api/v0/metric/posts', ['APIMetricsController', 'posts']);
Route::get('api/v0/metric/pendings', ['APIMetricsController', 'pendings']);
Route::get('api/v0/metric/usernames', ['APIMetricsController', 'usernames']);

// Private
Route::get('api/v0/account', ['APIAccountsController', 'account'], 'private');
Route::get('api/v0/settings', ['APISettingsController', 'settings'], 'private');

Route::post('api/v0/account', ['APIAccountsController', 'update'], 'private');

Route::get('api/v0/pending', ['APIPostsController', 'pending'], 'private');
Route::post('api/v0/post', ['APIPostsController', 'create'], 'private');

Route::get('api/v0/settings/timezones', ['APISettingsController', 'timezones'], 'private');
Route::post('api/v0/settings', ['APISettingsController', 'update'], 'private');
