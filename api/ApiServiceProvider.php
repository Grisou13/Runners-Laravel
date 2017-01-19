<?php

namespace Api;

use Api\ApiAuthProvider;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiServiceProvider extends RouteServiceProvider
{
    protected $namespace = 'Api\Controllers';

    protected $version = "v1";

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        app('Dingo\Api\Auth\Auth')->extend('access-token', function ($app) {
            return new ApiAuthProvider;
        });
        app('Dingo\Api\Transformer\Factory')->setAdapter(function ($app) {
            return new \Dingo\Api\Transformer\Adapter\Fractal(new \League\Fractal\Manager, 'include', ',');
        });
        //change the not found model exception to a symfony exception (dingo handles only symfony... )
        app('Dingo\Api\Exception\Handler')->register(function (ModelNotFoundException $exception) {
            throw new NotFoundHttpException($exception->getMessage() ,$previous = $exception);
        });
//        app('Dingo\Api\Exception\Handler')->register(function (NotAuthorized $exception) {
//            throw new NotFoundHttpException("akhgsdjaskd" ,$previous = $exception);
//        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
    public function map()
    {
        $api = app('Dingo\Api\Routing\Router');
        $api->group(['version'=>$this->version,'namespace' => $this->namespace . "\\" . $this->version,"middleware"=>"bindings"], function ($api) {
            require base_path('api/routes.php');
        });
    }
}
