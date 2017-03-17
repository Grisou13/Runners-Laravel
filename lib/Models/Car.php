<?php
/**
* User : Joël.DE-SOUSA
*/
namespace Lib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "plate_number","brand","model","color","nb_place","comment","name"
    ];
    public function user()
    {
      $car = $this;
      $subs = RunSubscription::whereHas("car", function($q) use ($car){
        return $q->where("id",$car->id);
      })->whereHas("run", function($q){
        return $q->where("ended_at","!=","null")->where("started_at","!=","null");// the run has started
      })->where("user_id","!=","null")->first();
      if(!$subs)
        return $subs->user;
      return null;
    }
    public function type()
    {
      return $this->car_type();
    }
    public function car_type()
    {
        return $this->belongsTo(CarType::class,$localKey="car_type_id");
    }
    public function runs()
    {
      return $this->belongsToMany(Run::class, "run_drivers")->using(RunDriver::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function setNameAttribute($value)
    {
      return $this->attributes["name"] = $this->car_type->name . " " . $value;
    }
}
