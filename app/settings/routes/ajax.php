<?php

use mavoc\core\Route;

Route::post('ajax/notifications/read', ['AjaxController', 'readAll'], 'private');
Route::post('ajax/notifications/unread', ['AjaxController', 'unreadAll'], 'private');
Route::post('ajax/notification/read/{notification_id}', ['AjaxController', 'read'], 'private');
Route::post('ajax/notification/unread/{notification_id}', ['AjaxController', 'unread'], 'private');
