<?php

use mavoc\console\Route;

Route::command('process', ['ConsoleController', 'process']);
Route::command('sandbox', ['ConsoleController', 'sandbox']);
Route::command('standing', ['ConsoleController', 'standing']);

Route::command('rsync', ['ConsoleController', 'rsync']);

Route::command('example', ['ConsoleController', 'example']);
Route::command('view', ['ConsoleController', 'view']);

