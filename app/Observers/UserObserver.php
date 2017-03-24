<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 23.03.2017
 * Time: 14:06
 */

namespace App\Observers;


use App\Events\RunDeletingEvent;
use App\Events\RunSubscriptionDeletedEvent;

class UserObserver
{
  public function subscribe($events)
  {

    $events->listen(
      'App\Events\RunDeletingEvent',
      [$this,'runIsDeleting']
    );
    $events->listen(
      "App\\Events\\RunStartedEvent",
      [$this,"makeUsersUnavailable"]
    );
    $events->listen(
      "App\\Events\\RunSubscriptionDeletedEvent",
      [$this,"makeUserAvailable"]
    );
    
  }
  public function makeUserAvailable(RunSubscriptionDeletedEvent $event)
  {
    //this will freee the user.
    // TODO check if the user isn't already in runs, or run_subs
    $event->run_subscription->user->status="free";
    $event->run_subscription->user->save();
  }
  public function runIsDeleting(RunDeletingEvent $event)
  {
    $run = $event->run;
    $run->subscriptions->map(function($sub){//FREE ALL THE USERS
      $sub->user->status="free";
    });
  }
}