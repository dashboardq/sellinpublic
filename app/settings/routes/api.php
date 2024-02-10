<?php

use mavoc\core\Route;

Route::get('api/metric/posts', ['APIMetricsController', 'posts']);
Route::get('api/metric/pendings', ['APIMetricsController', 'pendings']);
Route::get('api/metric/usernames', ['APIMetricsController', 'usernames']);

Route::get('api/v0/posts', ['APIPostsController', 'latest']);
