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

//Route::get('/', function () {
//    return view('welcome');
//});
$router->get("/",["as"=>"index","uses"=>"HomeController@welcome"]);
Auth::routes();

Route::get('/home', ["as"=>"home","uses"=>'HomeController@index']);

Route::resource("groups", "GroupController", ["only"=>["index"]]);
Route::resource('cars', 'CarController'); // Joël.DE-SOUSA
$router->post("cars/{car}/comment",["as"=>"cars.comments.store","uses"=>"CarController@addComment"]);

Route::resource('users', 'UserController', ["except"=>["create"]]); // Joël.DE-SOUSA
Route::post('upload/image', ['as' => 'image.upload', 'uses' => 'ImageController@upload']); // upload image for users // Joël.DE-SOUSA
