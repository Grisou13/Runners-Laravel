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
    $api->resource("users",'UserController');
    //convinience routes, these will mainly do internal requests
    $api->get("users/{user}/runs","UserController@run");
    $api->get("users/{user}/group","UserController@group");
    $api->match(["put","patch"],"/users/{user}/group/{group}","UserController@updateGroup");

    $api->get("users/me",["uses"=>"AuthenticatedUserController@me","as"=>"users.me"]);
    $api->get("users/me/runs","AuthenticatedUserController@runs");
    $api->get("users/me/schedule","AuthenticatedUserController@schedule");

    $api->resource("groups",'GroupController');
    $api->resource("cars",'CarController', ["except"=>["delete"]]);
    $api->resource("runs",'RunController');
//    $api->resource("itineraries","ItineraryController");
//    $api->resource("itineraries.waypoints","ItineraryWaypointController");
    $api->resource("waypoints","WaypointController");
});

//$api->get("/test",function(){
//    $dispatcher = app('Dingo\Api\Dispatcher');
//    return $dispatcher->get("api/users");
//});
