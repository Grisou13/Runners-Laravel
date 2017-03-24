<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:28
 */

namespace Lib\Models;
use Log;
use App\Concerns\StatusConcern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class RunWaypoint
 * This model is used to link a run to a car and/or a car type, with a runner
 * @package App
 */
class RunWaypoint extends Pivot
{
  public $table = "run_waypoint";
  public static function boot()
  {
    parent::boot();
    self::creating(function($self){
      dd("creating");
      $self->order = $self->order ?: $self->run->waypoints()->count()+1;
    });
  }
  public function setOrderAttribute($value)
  {
    Log::info("Setting order attribute on run waypoint");
    $this->attributes["order"] = $value ?: $this->run->waypoints()->count();
    Log::info("order of waypoint : ".$this->attributes["order"]);
  }
 public function waypoint()
 {
   return $this->belongsTo(Waypoint::class);
 }
 public function run()
 {
   return $this->belongsTo(Run::class);
 }
}
