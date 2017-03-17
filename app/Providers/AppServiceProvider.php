<?php

namespace App\Providers;

use App\Observers\RunObserver;
use App\Observers\RunSubObserver;
use Illuminate\Support\ServiceProvider;
use Lib\Models\Run;
use Lib\Models\RunSubscription;
use Lib\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      require_once app_path("Helpers/helpers.php");
      Run::observe(RunObserver::class);
      RunSubscription::observe(RunSubObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
