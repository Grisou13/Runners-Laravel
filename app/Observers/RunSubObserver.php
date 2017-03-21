<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.03.2017
 * Time: 10:02
 */

namespace App\Observers;
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

}