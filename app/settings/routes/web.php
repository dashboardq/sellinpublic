<?php

use mavoc\core\Route;

//Route::get('/', ['MainController', 'building']);
Route::get('/', ['MainController', 'home']);
//Route::get('latest', ['MainController', 'home']);
Route::get('about', ['MainController', 'about']);
Route::get('terms', ['MainController', 'terms']);
Route::get('privacy', ['MainController', 'privacy']);


// Private
Route::get('usernames', ['UsernameController', 'list'], 'private');
Route::get('username/add', ['UsernameController', 'add'], 'private');
Route::post('username/create', ['UsernameController', 'create'], 'private');

Route::get('post', ['PostsController', 'post'], 'private');
Route::post('post', ['PostsController', 'postPost'], 'private');
Route::get('pending', ['PostsController', 'pending'], 'private');

Route::get('account', ['AuthController', 'account'], 'private');
Route::post('account', ['AuthController', 'accountPost'], 'private');
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


