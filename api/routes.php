<?php
/**
 * Injected automatically view ApiServiceProvider
 * @var $api Dingo\Api\Routing\Router
 */
$api->version("v1",function(Dingo\Api\Routing\Router $api){
    $api->group(["middleware"=>["api.auth"]],function(Dingo\Api\Routing\Router $api){
        $api->get("users/me","UserController@me");
        $api->resource("users",'UserController');
        $api->resource("groups",'GroupController');
        $api->resource("cars",'CarController', ["except"=>"delete"]);
        $api->resource("runs",'RunController');

    });
});
