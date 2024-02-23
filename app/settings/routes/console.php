<?php

use mavoc\console\Route;

Route::command('process', ['ConsoleController', 'process']);

Route::command('rsync', ['ConsoleController', 'rsync']);

Route::command('example', ['ConsoleController', 'example']);
Route::command('view', ['ConsoleController', 'view']);

