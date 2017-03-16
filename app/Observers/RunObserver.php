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
  public function updating(Run $run)
  {
    if($run->ended_at != null)//if the run ended, we need do delete all subscriptions
      $run->subscriptions->map(function(RunSubscription $sub){
        $sub->delete();
      });
  }
  public function deleting(Run $run)
  {
    if($run->ended_at == null)
      $run->ended_at=Carbon::now();
    //automatically destroy all subs when a run is deleted
    $run->subscriptions->map(function(RunSubscription $sub){
      $sub->delete();
    });
  }
  public function created(Run $run)
  {
    
  }
  
}