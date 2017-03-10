<?php

namespace App\Providers;

use App\Observers\RunObserver;
use Illuminate\Support\ServiceProvider;
use Lib\Models\Run;
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
        Run::observe(RunObserver::class);
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
