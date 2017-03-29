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
    $api->get("/users/search",["as"=>"users.search","uses"=>"UserController@search"]);
    $api->resource("users",'UserController');
  
    $api->get("users/me",["uses"=>"AuthenticatedUserController@me","as"=>"users.me"]);
    $api->get("users/me/runs","AuthenticatedUserController@runs");
    $api->get("users/me/schedule","AuthenticatedUserController@schedule");
    //convinience routes, these will mainly do internal requests
    $api->get("users/{user}/image",["as"=>"user.image","uses"=>"UserController@image"]);
    $api->get("users/{user}/runs","UserController@run");
    $api->get("users/{user}/group","UserController@group");
    $api->match(["put","patch"],"/users/{user}/group/{group}","UserController@updateGroup");

    $api->resource("groups.schedules", "GroupScheduleController");
  
    $api->resource("schedules","ScheduleController");
    $api->resource("groups",'GroupController');
  
    $api->get("/cars/search",["as"=>"cars.search","uses"=>"CarController@search"]);
    $api->resource("cars",'CarController', ["except"=>["delete"]]);
    $api->get("/vehicles/search",["as"=>"vehicles.search","uses"=>"CarController@search"]);
    $api->resource("vehicles",'CarController', ["except"=>["delete"]]);
    
    $api->get("/car_types/search",["as"=>"car_types.search","uses"=>"CarTypeController@search"]);
    $api->resource("car_types","CarTypeController");
  
    $api->get("/waypoints/search",["as"=>"waypoints.search","uses"=>"WaypointController@search"]);
    $api->resource("waypoints","WaypointController");
  
    $api->get("/search/{model}","SearchController@fullText");
    $api->get("/search","SearchController@globalSearch");
  
    $api->resource("runners","SubscriptionController");
  
    $api->get("/status","StatusController@index");
    $api->get("/status/vehicle","StatusController@vehicle"); //not for us, but for ionic app
    $api->get("/status/{model}","StatusController@model");
  
    $api->group(["namespace"=>"Runs"],function($api){
      /**
       * @var $api Dingo\Api\Routing\Router
       */
      $api->get("/runs/search",["as"=>"runs.search","uses"=>"RunController@search"]);
      $api->resource("runs","RunController");
      
      $api->resource("runs.waypoints","WaypointController");
      $api->resource("runs.car_types","CarTypeController");
      $api->resource("runs.cars","CarController");
      $api->resource("runs.users","UserController");
      $api->resource("runs.subscriptions","SubscriptionController");
      $api->resource("runs.runners","SubscriptionController");
      
      $api->post("/runs/{run}/start",["as"=>"run.start","uses"=>"RunController@start"]);
      $api->post("/runs/{run}/stop",["as"=>"run.stop","uses"=>"RunController@stop"]);
      
      //adding cars to run
      $api->post("/runs/{run}/cars/{car}/join","CarController@join");
      $api->delete("/runs/{run}/cars/{car}/unjoin","CarController@unjoin");//deletes a user from a car
      //adding a user to a run
      $api->post("/runs/{run}/users/{user}/join","UserController@join");
      $api->delete("/runs/{run}/users/{user}/unjoin","UserController@unjoin"); //deletes a car from a user
    });
});

