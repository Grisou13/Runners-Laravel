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
  

}