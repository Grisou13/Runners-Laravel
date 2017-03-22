<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 10.03.2017
 * Time: 14:15
 */

namespace App\Observers;


use Carbon\Carbon;
use Lib\Models\Run;
use Lib\Models\RunSubscription;

class RunObserver
{

  public function deleting(Run $run)
  {
    if($run->ended_at == null)
      $run->ended_at=Carbon::now();
    //automatically destroy all subs when a run is deleted
    $run->subscriptions->map(function(RunSubscription $sub){
      $sub->delete();
    });
  }

  public function subscribe($events)
  {
    $events->listen(
      'Illuminate\Auth\Events\Login',
      'App\Listeners\UserEventSubscriber@onUserLogin'
    );

    $events->listen(
      'Illuminate\Auth\Events\Logout',
      'App\Listeners\UserEventSubscriber@onUserLogout'
    );
  }
}