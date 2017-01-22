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
     * Publishes the configuration files in config/ in laravel's config system
     * @return void
     */
    public function publishConfigs()
    {
      return;
        $this->publishes([
            __DIR__.'/config/request_filtering.php' => config_path('api-filter.php'),
        ]);
    }
    /**
     * Merges the configs that are modified by user, and original configs
     * @return void
     */
    public function mergeConfigs()
    {
      return;
        $this->mergeConfigFrom(
            __DIR__.'/config/request_filtering.php', 'api-filter.php'
        );
    }
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->publishConfigs();

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
      $this->mergeConfigs();
    }
    public function map()
    {
        $api = app('Dingo\Api\Routing\Router');
        $api->group(['version'=>$this->version,'namespace' => $this->namespace . "\\" . ucfirst($this->version),"middleware"=>"bindings"], function ($api) {
            require base_path('api/routes.php');
        });
    }


}
