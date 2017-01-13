<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
/**
 * @var Dingo\Api\Routing\Router
 */
$api = app('Dingo\Api\Routing\Router');
$api->version("v1",function($api){
    $api->group(['namespace' => 'App\Http\Controllers\Api\V1'],function($api){
        $api->get("/",function(){
            return "hi";
        });
        $api->resource("user",'UserController');
        $api->resource("group",'GroupController');
        $api->resource("car",'CarController', ["except"=>"delete"]);
        $api->resource("run",'UserController');

    });
});
