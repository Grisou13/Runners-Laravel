<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Run extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "name","start_at","end_at","geo_from","geo_to","note", "nb_passenger", "artist"
    ];
    protected $appends =["start_location","end_location"];
    protected $dates = [
        "created_at",
        "updated_at",
        "start_at",
        "end_at"
    ];
    public function waypoints(){
      return $this->hasMany(Waypoint::class);
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
      return "run from ".self::resolveGeoLocationName($this->waypoints->first());
    }
    public static function resolveGeoLocationName($geo){
      return $geo["address_components"][0]["long_name"];//force first element of result
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
