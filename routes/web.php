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
/**
 * @var $router Illuminate\Routing\Router
 */
/**
 * ----------------------------------
 * | Auth
 * ----------------------------------
 * |
 * | Auth is defined by per controller.
 * |
 * | This enables controllers to know
 * | What to do with a user.
 * |
 */
$router->get("/",["as"=>"index","uses"=>"HomeController@welcome"]);
Auth::routes();


Route::get('/home', ["as"=>"home","uses"=>'HomeController@index']);

Route::resource("groups", "GroupController",["only"=>["index"]]);
Route::resource("schedule", "ScheduleController",["only"=>["index"]]);
Route::resource("kiela", "KielaController",["only"=>["index"]]);
$router->post("cars/{car}/comments",["as"=>"cars.comments.store","uses"=>"CarController@addComment"]);
$router->delete("cars/{car}/comments/{comment}", ["as"=>"cars.comments.destroy", "uses"=>"CarController@removeComment"]);
Route::resource('cars', 'CarController');

$router->get("runs/display",["as"=>"runs.display","uses"=>"RunController@display"]);
$router->get("runs/pdf",["as"=>"runs.pdf","uses"=>"RunController@pdf"]);
//$router->get("runs/pdf/template","RunController@pdfTemplate");
Route::post("runs/{run}/publish",   ["as"=>"runs.publish",        "uses"=>"RunController@publish"]);

$router->post("runs/{run}/comments",  ["as"=>"runs.comments.store", "uses"=>"RunController@addComment"]);
$router->post("runs/{run}/start",     ["as"=>"runs.start",          "uses"=>"RunController@start"]);
$router->post("runs/{run}/stop",      ["as"=>"runs.stop",           "uses"=>"RunController@stop"]);

$router->resource("runs","RunController");

Route::get('users/{user}/profile', ['uses' => 'UserController@redirectToUser']);
Route::get('users/{user}/license', ['uses' => 'UserController@redirectToUser']);

Route::post('users/{user}/profile', ['as' => 'image.profile', 'uses' => 'UserController@storeProfileImage']);
Route::post('users/{user}/license', ['as'=>'image.license',   'uses' => 'UserController@storeLicenseImage']);
$router->post("users/{user}/reset_password",["as"=>"users.reset","uses"=>"UserController@resetPassword"]);
Route::resource('users', 'UserController'); // Joël.DE-SOUSA
