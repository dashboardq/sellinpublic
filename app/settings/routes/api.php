<?php

use mavoc\core\Route;

Route::get('api/metric/posts', ['APIMetricsController', 'originalPosts']);
Route::get('api/metric/pendings', ['APIMetricsController', 'originalPendings']);
Route::get('api/metric/usernames', ['APIMetricsController', 'originalUsernames']);



// Public
Route::get('api/v0/hello', ['APIMiscController', 'hello']);
Route::post('api/v0/hello', ['APIMiscController', 'helloSubmit']);
Route::get('api/v0/latest', ['APIPostsController', 'latest']);

Route::get('api/v0/metric/posts', ['APIMetricsController', 'posts']);
Route::get('api/v0/metric/pendings', ['APIMetricsController', 'pendings']);
Route::get('api/v0/metric/usernames', ['APIMetricsController', 'usernames']);

Route::get('api/v0/timeline/user/{username}', ['APIPostsController', 'timelineUser']);
Route::get('api/v0/post/children/{post_id}', ['APIPostsController', 'children']);
Route::get('api/v0/post/single/{post_id}', ['APIPostsController', 'single']);

Route::get('api/v0/reactions/flags/all', ['APIReactionsController', 'flagsAll']);
Route::get('api/v0/reactions/stars/all', ['APIReactionsController', 'starsAll']);
Route::get('api/v0/reactions/flags/{post_id}', ['APIReactionsController', 'flagsPost']);
Route::get('api/v0/reactions/stars/{post_id}', ['APIReactionsController', 'starsPost']);

Route::get('api/v0/profile/{username}', ['APIAccountsController', 'profile']);


// Private
Route::get('api/v0/account', ['APIAccountsController', 'account'], 'private');
Route::get('api/v0/settings', ['APISettingsController', 'settings'], 'private');

Route::post('api/v0/account', ['APIAccountsController', 'update'], 'private');

Route::get('api/v0/notifications', ['APINotificationsController', 'list'], 'private');
Route::get('api/v0/notifications/count', ['APINotificationsController', 'count'], 'private');
Route::get('api/v0/notifications/count/unread', ['APINotificationsController', 'countUnread'], 'private');
Route::post('api/v0/notification/read/{notification_id}', ['APINotificationsController', 'read'], 'private');
Route::post('api/v0/notification/unread/{notification_id}', ['APINotificationsController', 'unread'], 'private');
Route::post('api/v0/notifications/read', ['APINotificationsController', 'readAll'], 'private');
Route::post('api/v0/notifications/unread', ['APINotificationsController', 'unreadAll'], 'private');

Route::get('api/v0/pending', ['APIPostsController', 'pending'], 'private');
Route::post('api/v0/post', ['APIPostsController', 'create'], 'private');

Route::get('api/v0/reactions/stars', ['APIReactionsController', 'stars'], 'private');
Route::post('api/v0/flag/{post_id}', ['APIReactionsController', 'flag'], 'private');
Route::post('api/v0/star/{post_id}', ['APIReactionsController', 'star'], 'private');
Route::post('api/v0/unflag/{post_id}', ['APIReactionsController', 'unflag'], 'private');
Route::post('api/v0/unstar/{post_id}', ['APIReactionsController', 'unstar'], 'private');

Route::get('api/v0/settings/timezones', ['APISettingsController', 'timezones'], 'private');
Route::post('api/v0/settings', ['APISettingsController', 'update'], 'private');

