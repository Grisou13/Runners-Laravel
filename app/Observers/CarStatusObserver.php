<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 22.03.2017
 * Time: 09:33
 */

namespace App\Observers;


use App\Helpers\Status;
use Lib\Models\Car;

class CarStatusObserver
{
  public function saving(Car $car)
  {
    $car->status = $car->user() != null ? Status::getCarStatus("taken") : Status::getCarStatus("free");
    $car->save();
  }
}