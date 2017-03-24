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
use App\Events\RunSubscriptionDeletingEvent;
use App\Events\RunSubscriptionSavingEvent;
use App\Events\UserCreatingEvent;

class UserObserver
{
  public function subscribe($events)
  {

    $events->listen(
      'App\Events\RunDeletingEvent',
      [$this,'runIsDeleting']
    );
//    $events->listen(
//      "App\\Events\\RunStartedEvent",
//      [$this,"makeUsersUnavailable"]
//    );
    $events->listen(
      "App\\Events\\RunSubscriptionDeletingEvent",
      [$this,"makeUserAvailable"]
    );
    $events->listen(
      "App\\Events\\RunSubscriptionSavingEvent",
      [$this,"makeUserUnavailable"]
    );
  
    $events->listen(
      "App\\Events\\UserCreatingEvent",
      [$this,"userCreating"]
    );
    
  }
  public function makeUserUnavailable(RunSubscriptionSavingEvent $event)
  {
    if($event->run_subscription->user_id != null)
    {
      $user = $event->run_subscription->user;
      $user->status="taken";
      $user->save();
    }
  }
  public function makeUserAvailable(RunSubscriptionDeletingEvent $event)
  {
    if($event->run_subscription->user_id != null)
    {
      $user = $event->run_subscription->user;
      $user->status="free";
      $user->save();
    }
    
  }
  public function userCreating(UserCreatingEvent $event)
  {
    $user = $event->user;
    $user->status="free";//when creating a user, we set his status to free
    //$user->save();
  }

  public function runIsDeleting(RunDeletingEvent $event)
  {
    $run = $event->run;
    $run->subscriptions->map(function($sub){//FREE ALL THE USERS
      if($sub->user_id != null)
        $sub->user->status="free";
    });
  }
}