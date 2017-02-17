<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Run extends Model
{
    use SoftDeletes,ValidatingTrait;
    public $rules = [
      "name"=>"required_unless:artist,''",
      "artist"=>"required_unless:name,''",
    ];
    protected $fillable = [
        "name","started_at","planned_at","note","ended_at", "nb_passenger", "artist"
    ];
    protected $appends =["start_location","end_location"];
    protected $dates = [
        "created_at",
        "updated_at",
        "start_at",
        "end_at"
    ];
    public function waypoints(){
      //all fields selected in pivot table are prefixed with pivot_*
      return $this->belongsToMany(Waypoint::class)->withPivot("order")->orderBy("pivot_order","ASC");
    }

    public function setNameAttribute($name){
      $this->attributes['name'] = $name ? $name : $this->defaultRunName();
    }
    public function getEndLocationAttribute(){
      return $this->waypoints->last();
    }
    public function getStartLocationAttribute(){
      return $this->waypoints->first();
    }
    protected function defaultRunName(){
      if(array_key_exists("artist",$this->attributes))
        return $this->attributes["artist"];
      return self::resolveGeoLocationName($this->waypoints->first());
    }
    public static function resolveGeoLocationName($waypoint){
      return $waypoint->geo["address_components"][0]["short_name"];//force first element of result
    }
    public function runners()
    {
        return $this->belongsToMany(User::class)->using(RunDriver::class);
    }
    public function cars()
    {
        return $this->belongsToMany(Car::class)->using(RunDriver::class);
    }
    public function car_types()
    {
      return $this->belongsToMany(CarType::class)->using(RunDriver::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
