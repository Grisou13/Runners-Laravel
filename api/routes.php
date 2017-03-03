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

    $api->resource("groups.schedules", "GroupScheduleController");
    $api->resource("schedules","ScheduleController");
    $api->get("users/me",["uses"=>"AuthenticatedUserController@me","as"=>"users.me"]);
    $api->get("users/me/runs","AuthenticatedUserController@runs");
    $api->get("users/me/schedule","AuthenticatedUserController@schedule");
  
    $api->resource("groups",'GroupController');
    $api->resource("cars",'CarController', ["except"=>["delete"]]);
    $api->group(["namespace"=>"Runs"],function($api){
      /**
       * @var $api Dingo\Api\Routing\Router
       */
      $api->resource("runs","BaseController");
      $api->resource("runs.waypoints","WaypointController");
      $api->resource("runs.car_types","CarTypeController");
      $api->resource("runs.cars","CarController");
      $api->resource("runs.runners","RunnerController");
      $api->resource("runs.users","UserController");
    });
    $api->get("/statuses","StatusController@index");
    $api->resource("waypoints","WaypointController");
    $api->get("/search/{model}","SearchController@fullText");
});

