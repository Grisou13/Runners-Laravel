<?php
/**
* User: Thomas.RICCI
*/
/**
 * @see \Api\ApiServiceProvider
 * @var $api Dingo\Api\Routing\Router
 */


$api->get("/","HomeController@home");
$api->get("/ping","HomeController@ping");
$api->get("/spec.yaml","HomeController@spec");
/**
 * ----------------------------------
 * | Auth
 * ----------------------------------
 * |
 * | Auth is defined by routes here.
 * |
 * | This is beacause all endpoints
 * | most of the api are protected
 * |
 */
$api->group(["middleware"=>["api.auth"]],function(Dingo\Api\Routing\Router $api){
    $api->get("/users/search",["as"=>"users.search","uses"=>"UserController@search"]);

    $api->get("/me",["uses"=>"AuthenticatedUserController@me","as"=>"users.me"]);
    $api->get("/me/workinghours",function(){
      $first_start = \DB::table("runs")->orderBy("planned_at","ASC")->first()->planned_at;
	$first_date = \Carbon\Carbon::parse($first_start);

      $ret = [];
      // from 10 -> 20 days ago
      $to = rand(10,20);
      for($i = 0; $i <= $to; $i++){
        $start = $first_date;
        $start = $start->addDays($i);
        $ret[] = [
          "start_at"=>(string)$start,
          "end_at"=> (string)$start->addHours(rand(2,8))
        ];
      }
      return $ret;
    });
    $api->get("users/me",["uses"=>"AuthenticatedUserController@me"]);
    $api->get("/me/runs","AuthenticatedUserController@runs");
    $api->get("/me/schedule","AuthenticatedUserController@schedule");
    //convinience routes, these will mainly do internal requests
    $api->get("users/{user}/image",["as"=>"user.image","uses"=>"UserController@image"]);
    $api->get("users/{user}/runs","UserController@run");
    $api->get("users/{user}/group","UserController@group");
    $api->match(["put","patch"],"/users/{user}/group/{group}","UserController@updateGroup");
    $api->resource("users",'UserController');

    $api->resource("groups.schedules", "GroupScheduleController");

    $api->resource("schedules","ScheduleController");
    $api->group(["namespace"=>"Groups"],function($api){
      /**
       * @var $api Dingo\Api\Routing\Router
       */
      $api->resource("groups",'GroupController');
      $api->resource("groups.users",'UserController',["except"=>"update"]);
    });


    //$api->resource("kiela", "KielaController");
    $api->resource("settings", "SettingController");

    $api->group(["namespace"=>"Cars"],function($api) {
      /**
       * @var $api Dingo\Api\Routing\Router
       */
      $api->get("/cars/search",["as"=>"cars.search","uses"=>"CarController@search"]);
      $api->get("/vehicles/search",["as"=>"vehicles.search","uses"=>"CarController@search"]);

      $api->get("/cars/{car}/type",["as"=>"cars.type","uses"=>"CarController@type"]);
      $api->get("/vehicles/{vehicle}/type",["as"=>"cars.type","uses"=>"CarController@type"]);

      $api->resource("cars.comments","CommentController",["except"=>["update"]]);
      $api->resource("vehicles.comments", "CommentController", ["except"=>["update"]]);
      $api->resource("cars",'CarController');
      $api->resource("vehicles",'CarController');
    });


    $api->get("/car_types/search",["as"=>"car_types.search","uses"=>"CarTypeController@search"]);
    $api->get("/car_types/{car_type}/cars",["as"=>"car_types.cars","uses"=>"CarTypeController@carList"]);
    $api->resource("car_types","CarTypeController");

    $api->get("/waypoints/search",["as"=>"waypoints.search","uses"=>"WaypointController@search"]);
    $api->resource("waypoints","WaypointController", ["except"=>"update"]);

    $api->get("/search/{model}","SearchController@fullText");
    $api->get("/search","SearchController@globalSearch");

    $api->resource("runners","SubscriptionController");

    $api->get("/status","StatusController@index");
    $api->get("/status/vehicle","StatusController@vehicle"); //not for us, but for ionic app
    $api->get("/status/vehicles","StatusController@vehicle"); //not for us, but for ionic app

    $api->get("/status/{model}","StatusController@model");

    $api->group(["namespace"=>"Runs"],function($api){
      /**
       * @var $api Dingo\Api\Routing\Router
       */
      $api->get("/runs/search",["as"=>"runs.search","uses"=>"RunController@search"]);
      $api->post("/runs/{run}/publish",["as"=>"runs.publish","uses"=>"RunController@publish"]);
      $api->post("/runs/{run}/start",["as"=>"runs.start","uses"=>"RunController@start"]);
      $api->post("/runs/{run}/stop",["as"=>"runs.stop","uses"=>"RunController@stop"]);
      $api->resource("runs","RunController");

      $api->delete("/runs/{run}/waypoints",["as"=>"runs.waypoints.destroy_all","uses"=>"WaypointController@deleteAll"]);
      $api->resource("runs.waypoints","WaypointController");
      $api->resource("runs.comments","CommentController");
      //this route is used as a shorthand for drivers to directly target the subscription they are in
      $api->post("/runs/{run}/subscriptions/{subscription}/start",["as"=>"runs.sub.start","uses"=>"SubscriptionController@start"]);
      $api->post("/runs/{run}/subscriptions/{subscription}/stop",["as"=>"runs.sub.stop","uses"=>"SubscriptionController@stop"]);
      $api->resource("runs.subscriptions","SubscriptionController");

      $api->post("/runs/{run}/runners/{runner}/start",["as"=>"runs.runner.start","uses"=>"SubscriptionController@start"]);
      $api->post("/runs/{run}/runners/{runner}/stop",["as"=>"runs.runner.stop","uses"=>"SubscriptionController@stop"]);
      $api->resource("runs.runners","SubscriptionController");

    });
});
