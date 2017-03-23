<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.03.2017
 * Time: 10:02
 */

namespace App\Observers;
use App\Events\RunDeletingEvent;
use App\Events\RunSubscriptionSavingEvent;
use Lib\Models\RunSubscription;

class RunSubObserver
{
  public function creating(RunSubscription $sub)
  {

  }
  public function updating(RunSubscription $sub)
  {

  }
  public function saving(RunSubscription $sub)
  {
      if($sub->has("car") && !$sub->has("car_type"))// just fill in the car type
          $sub->car_type()->associate($sub->car->car_type)->save();
      if($sub->has("car") && $sub->has("user"))
      {
          $sub->status = "ready_to_go";
      }
  }
  public function subscriptionIsSaving(RunSubscriptionSavingEvent $event)
  {
    $sub = $event->run_subscription;
    if($sub->car_id != null && $sub->user_id !=null )
      $sub->status = "ready_to_go";
    else if ( $sub->car_id == null  && $sub->user_id != null )
      $sub->status = "missing_car";
    else if($sub->user_id == null )
      $sub->status="missing_user";
    else
      $sub->status="needs_filling";
    
    if($sub->car_id != null)
      $sub->car->status="taken";
  }
  public function deleteSubsForRun(RunDeletingEvent $event)
  {
    $run = $event->run;
    $run->subscriptions->map(function(RunSubscription $sub){
      $sub->delete();
    });
  }
  public function subscribe($events)
  {
    $events->listen(
      'App\Events\RunSubscriptionSavingEvent',
      [$this,'subscriptionIsSaving']
    );
    $events->listen(
      'App\Events\RunDeletingEvent',
      [$this,'deleteSubsForRun']
    );
    
  }

}