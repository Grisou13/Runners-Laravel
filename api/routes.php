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
    $api->get("users/{user}/image",["as"=>"user.image","uses"=>"UserController@image"]);
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
  
    $api->get("/status","StatusController@index");
    $api->get("/status/{model}","StatusController@model");
    $api->resource("waypoints","WaypointController");
    $api->get("/search/{model}","SearchController@fullText");
  
    $api->group(["namespace"=>"Runs"],function($api){
      /**
       * @var $api Dingo\Api\Routing\Router
       */
      $api->resource("runs","RunController");
      $api->resource("runs.waypoints","WaypointController");
      $api->resource("runs.car_types","CarTypeController");
      $api->resource("runs.cars","CarController");
      $api->resource("runs.users","UserController");
      $api->post("/runs/{run}/start",["as"=>"run.start","uses"=>"RunController@start"]);
      $api->post("/runs/{run}/stop",["as"=>"run.stop","uses"=>"RunController@stop"]);
      //adding cars to run
      $api->post("/runs/{run}/cars/{car}/join","CarController@join");
      $api->delete("/runs/{run}/cars/{car}/unjoin","CarController@unjoin");//deletes a user from a car
      //adding a user to a run
      $api->post("/runs/{run}/users/{user}/join","UserController@join");
      $api->delete("/runs/{run}/users/{user}/unjoin","UserController@unjoin"); //deletes a car from a user
      //adding a car type
//      $api->post("/runs/{run}/car_types/{car_type}/join","CarTypeController@join");
//      $api->delete("/runs/{run}/car_types/{car_type}/join","CarTypeController@unjoin");
  
      $api->resource("runs.subscriptions","SubscriptionController");
      $api->resource("runs.runners","SubscriptionController");
    });
    
});

