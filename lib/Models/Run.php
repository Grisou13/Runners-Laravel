<?php

namespace Lib\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use Lib\Concerns\SortablePivotTrait;
class Run extends Model
{
    use SoftDeletes,ValidatingTrait,SortablePivotTrait;
    public $rules = [
      "name"=>"required_if:artist,''",
    ];
    protected $fillable = [
        "name","started_at","planned_at","note","ended_at", "nb_passenger", "artist"
    ];
    //protected $appends =["start_location","end_location"];
    protected $dates = [
        "created_at",
        "updated_at",
        "started_at",
        "ended_at",
        "planned_at"
    ];
    public function waypoints(){
      //all fields selected in pivot table are prefixed with pivot_*
      return $this->sortableBelongsToMany(Waypoint::class,"order")->withPivot("order");
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
    public function users()
    {
        return $this->belongsToMany(User::class,"run_drivers")->using(RunDriver::class)->withPivot(["car_type_id","car_id"]);
    }
    public function cars()
    {
        return $this->belongsToMany(Car::class,"run_drivers")->using(RunDriver::class)->withPivot(["user_id","car_type_id"]);
    }
    public function car_types()
    {
        return $this->belongsToMany(CarType::class,"run_drivers")->using(RunDriver::class)->withPivot(["user_id","car_id"]);
    }
    public function subscriptions()
    {
        return $this->hasMany(RunSubscription::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
