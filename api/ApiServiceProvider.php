<?php
/**
* User: Thomas.RICCI
*/
namespace Api;

use Api\ApiAuthProvider;
use Api\Responses\Transformers\CarTransformer;
use Api\Responses\Transformers\CarTypeTransformer;
use Api\Responses\Transformers\RunSubscriptionTransformer;
use Api\Responses\Transformers\RunTransformer;
use Api\Responses\Transformers\UserTransformer;
use App\Providers\RouteServiceProvider;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException as LaravelValidationException;
use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;
use Lib\Models\Car;
use Lib\Models\CarType;
use Lib\Models\Run;
use Lib\Models\RunSubscription;
use Lib\Models\User;
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
            __DIR__.'/config/api.php' => config_path('api.php'),
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
            __DIR__.'/config/api.php', 'api.php'
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
          $fractal = new Manager;
          $fractal->setSerializer(new Responses\NoDataArraySerializer);
          return new Fractal($fractal,"include",",",false);
        });
        //change the not found model exception to a symfony exception (dingo handles only symfony... )
        app('Dingo\Api\Exception\Handler')->register(function (ModelNotFoundException $exception) {
            throw new NotFoundHttpException($exception->getMessage() ,$previous = $exception);
        });
        app('Dingo\Api\Exception\Handler')->register(function (LaravelValidationException $exception) {
            throw new ValidationHttpException($exception->validator->errors() ,$previous = $exception);
        });
        //in case oif model validation failing, we must display the right Dingo exception
        app('Dingo\Api\Exception\Handler')->register(function (\Watson\Validating\ValidationException $exception) {
            throw new ValidationHttpException($exception->validator->errors() ,$previous = $exception);
        });
        $this->registerModelBindings();
    }
    protected function registerModelBindings()
    {
      app('Dingo\Api\Transformer\Factory')->register(User::class, UserTransformer::class);
      app('Dingo\Api\Transformer\Factory')->register(Run::class, RunTransformer::class);
      app('Dingo\Api\Transformer\Factory')->register(RunSubscription::class, RunSubscriptionTransformer::class);
      app('Dingo\Api\Transformer\Factory')->register(Car::class, CarTransformer::class);
      app('Dingo\Api\Transformer\Factory')->register(CarType::class, CarTypeTransformer::class);
  
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
