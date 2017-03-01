<?php
/**
* User: Thomas.RICCI
*/
/**
 * Injected automatically view ApiServiceProvider
 * @var $api Dingo\Api\Routing\Router
 */
$api->get("/","HomeController@home");
$api->get("/ping","HomeController@ping");
$api->group(["middleware"=>["api.auth"]],function(Dingo\Api\Routing\Router $api){
    $api->get("users/me",["uses"=>"UserController@me","as"=>"users.me"]);
    $api->resource("users",'UserController');
    //convinience routes, these will mainly do internal requests
    $api->get("users/{user}/runs","UserController@run");
    $api->get("users/me/runs","UserController@run");
    $api->get("users/{user}/group","UserController@group");
    $api->get("users/me/group","UserController@group");

    $api->resource("groups.schedules", "ScheduleController");

    $api->resource("groups",'GroupController');
    $api->resource("cars",'CarController', ["except"=>"delete"]);
    $api->resource("runs",'RunController');


});

//$api->get("/test",function(){
//    $dispatcher = app('Dingo\Api\Dispatcher');
//    return $dispatcher->get("api/users");
//});
