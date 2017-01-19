<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

<<<<<<< HEAD
Route::resource("/groups", "GroupController");

Auth::routes();

Route::get('/home', 'HomeController@index');
Discard all changes
Unstaged Files (0)
Name
Expand All
Tree View
Staged Files (4)Unstage all changes
Name
Expand All
Tree View
config
1
resources
views
layouts
app.blade.php
routes
web.php
composer.lock
=======
Route::resource('car', 'CarController');

Auth::routes();
>>>>>>> api-v1
