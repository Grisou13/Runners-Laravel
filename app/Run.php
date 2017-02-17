<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Run extends Model
{
    use SoftDeletes,ValidatingTrait;
    public $rules = [
      "name"=>"required_if:artist,''",
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
    public static function boot()
    {
      parent::boot();
      self::creating(function($self){
        $self->name = $self->name ? $self->name : $self->defaultRunName();
      });
    }

    public function getEndLocationAttribute(){
      return $this->waypoints->last();
    }
    public function getStartLocationAttribute(){
      return $this->waypoints->first();
    }
    public function defaultRunName(){
      //try getting the name from the artist
      if(array_key_exists("artist",$this->attributes))
        return $this->attributes["artist"];
      //or maybe the starting point name
      return self::resolveGeoLocationName($this->waypoints->first()->geo);
    }
    public static function resolveGeoLocationName($geo){
      return $geo["address_components"][0]["short_name"];//force first element of result
    }
    public function runners()
    {
        return $this->belongsToMany(User::class,"run_drivers")->using(RunDriver::class);
    }
    public function cars()
    {
        return $this->belongsToMany(Car::class,"run_drivers")->using(RunDriver::class);
    }
    
    public function car_types()
    {
      return $this->belongsToMany(CarType::class,"run_drivers")->using(RunDriver::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
