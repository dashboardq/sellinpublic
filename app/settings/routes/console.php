<?php

use mavoc\console\Route;

Route::command('process', ['ConsoleController', 'process']);

Route::command('example', ['ConsoleController', 'example']);
Route::command('view', ['ConsoleController', 'view']);

