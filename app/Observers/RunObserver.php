<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 10.03.2017
 * Time: 14:15
 */

namespace App\Observers;


use App\Events\RunDeletedEvent;
use App\Events\RunDeletingEvent;
use App\Events\RunFinishedEvent;
use App\Events\RunSavingEvent;
use App\Events\RunSubscriptionSavedEvent;
use Carbon\Carbon;
use Lib\Models\Run;
use Lib\Models\RunSubscription;

class RunObserver
{
  public function subscribe($events)
  {
    $events->listen(
      'App\Events\RunSubscriptionSavedEvent',
      [$this,'updateRunStatus']
    );
    $events->listen(
      'App\Events\RunSubscriptionDeletedEvent',
      [$this,'updateRunStatus']);
    
    $events->listen(
      'App\Events\RunSavingEvent',
      [$this,'savingRun']
    );
    $events->listen(
      'App\Events\RunDeletingEvent',
      [$this,'runIsDeleting']
    );
    $events->listen(
      'App\Events\RunDeletedEvent',
      [$this,'runWasDeleted']
    );
  }
  public function runIsDeleting(RunDeletingEvent $event)
  {
    //when a run is deleted, we consider it to be finished
    $run = $event->run;
    if($run->ended_at == null)
      $run->ended_at = Carbon::now();
  }
  
  public function savingRun(RunSavingEvent $event)
  {
    //update all subscriptions notifying them they are gone
    $run = $event->run;
    $this->adaptRunStatus($run);
  }
  public function updateRunStatus($event)
  {
    
    $run = $event->run;
    if($run->subscriptions()->ofStatus("ready_to_go")->count() == $run->subscriptions()->count())
      $run->status = "ready";
    else
      $run->status="error";
    $run->save();
    //$this->adaptRunStatus($event->run);
  }
  public function runWasDeleted(RunDeletedEvent $event)
  {
    event(new RunFinishedEvent($event->run));
  }
  
  
  protected function adaptRunStatus(Run $run)
  {
    if($run->started_at != null && $run->ended_at != null)
    {
      $run->status="gone";
      $run->subscriptions->map(function($sub){
        $sub->status = "gone";
      });
    }
    else{
      if($run->subscriptions()->count() > 0 )
      {
        if($run->started_at==null && $run->ended_at == null )
        {
          if($run->subscriptions()->ofStatus("ready_to_go")->count() == $run->subscriptions()->count())
            $run->status = "ready";
          else
            $run->status="error";
        }
      }
      else
      {
        $run->status="needs_filling";
      }
    }
    
  }
}