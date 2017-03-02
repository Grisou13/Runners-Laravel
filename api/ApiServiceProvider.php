<?php
/**
* User: Thomas.RICCI
*/
namespace Api;

use Api\ApiAuthProvider;
use App\Providers\RouteServiceProvider;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;
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
      
        
//        $this->app->bind('League\Fractal\Manager', function($app) {
//          $fractal = new Manager();
//          $serializer = new ArraySerializer();
//          $fractal->setSerializer($serializer);
//
//          return $fractal;
//        });
//        $this->app->bind('Dingo\Api\Transformer\Adapter\Fractal', function($app) {
//          $fractal = $app->make('\League\Fractal\Manager');
//          $serializer = new \League\Fractal\Serializer\ArraySerializer();
//
//          $fractal->setSerializer($serializer);
//          return new \Dingo\Api\Transformer\Adapter\Fractal($fractal);
//        });

        app('Dingo\Api\Auth\Auth')->extend('access-token', function ($app) {
            return new ApiAuthProvider;
        });
        app('Dingo\Api\Transformer\Factory')->setAdapter(function ($app) {
          $fractal = new \League\Fractal\Manager;
          $fractal->setSerializer(new \Api\Responses\NoDataArraySerializer);
          return new \Dingo\Api\Transformer\Adapter\Fractal($fractal);
        });
        //change the not found model exception to a symfony exception (dingo handles only symfony... )
        app('Dingo\Api\Exception\Handler')->register(function (ModelNotFoundException $exception) {
            throw new NotFoundHttpException($exception->getMessage() ,$previous = $exception);
        });
        //in case oif model validation failing, we must display the right Dingo exception
        app('Dingo\Api\Exception\Handler')->register(function (\Watson\Validating\ValidationException $exception) {
            throw new ValidationHttpException($exception->getMessage() ,$previous = $exception);
        });

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
        if(is_array($this->version) || $this->version instanceof Collection)
        {
          foreach($this->version as $version)
          {
            $api->group(['version'=>$version,'namespace' => $this->namespace . "\\" . ucfirst($version),"middleware"=>"bindings"], function ($api) use($version) {
              require base_path("api/routes_".$version.".php");
            });
          }
        }
        else
        {
          $api->group(['version'=>$this->version,'namespace' => $this->namespace . "\\" . ucfirst($this->version),"middleware"=>"bindings"], function ($api) {
            require base_path('api/routes.php');
          });
        }
        
    }


}
