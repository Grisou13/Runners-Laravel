<?php

namespace App\Providers;

use App\Observers\CarStatusObserver;
use App\Observers\RunObserver;
use App\Observers\RunSubObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Lib\Models\Car;
use Lib\Models\Run;
use Lib\Models\RunSubscription;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        
    ];
  
    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
      'App\Observers\RunObserver',
      'App\Observers\RunSubObserver',
      'App\Observers\UserObserver',
      'App\Observers\CarObserver'
    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        
    }
}
