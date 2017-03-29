<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 23.03.2017
 * Time: 14:06
 */

namespace App\Observers;


use App\Events\CarCreatingEvent;
use App\Events\CarSavingEvent;
use App\Events\RunDeletingEvent;
use App\Events\RunSubscriptionDeletingEvent;
use App\Events\RunSubscriptionSavingEvent;

class CarObserver
{
  public function subscribe($events)
  {
    $events->listen(
      'App\Events\RunDeletingEvent',
      [$this,'runIsDeleting']
    );
    $events->listen(
      "App\\Events\\RunStartedEvent",
      [$this,"makeCarsUnavailable"]
    );
    $events->listen(
      "App\\Events\\RunSubscriptionDeletingEvent",
      [$this,"makeCarAvailable"]
    );
    $events->listen(
      "App\\Events\\RunSubscriptionSavingEvent",
      [$this,"makeCarUnavailable"]
    );
    $events->listen(
      "App\\Events\\CarCreatingEvent",
      [$this,"carIsCreating"]
    );
  }
  public function carIsCreating(CarCreatingEvent $event)
  {
    $event->car->status="free";
  }
  public function makeCarAvailable(RunSubscriptionDeletingEvent $event)
  {
    if($event->run_subscription->car_id != null)
    {
      $car = $event->run_subscription->car;
      $car->status="free";
      $car->save();
    }
  }
  public function makeCarUnavailable(RunSubscriptionSavingEvent $event)
  {
    if($event->run_subscription->car_id != null)
    {
      $car = $event->run_subscription->car;
      if($event->run_subscription->car_type_id != null)
        $event->run_subscription->car_type()->associate($car->car_type_id)->save();
      $car->status="taken";
      $car->save();
    }
  }
  public function runIsDeleting(RunDeletingEvent $event)
  {
    $run = $event->run;
    $run->subscriptions->map(function($sub){
      if($sub->car_id != null)
        $sub->car->status="free";
    });
  }
}