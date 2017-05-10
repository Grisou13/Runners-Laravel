<?php

namespace Lib\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Waypoint extends Model
{
  use ValidatingTrait;
  public $rules = [
    //"name"=>"required",
  ];
  
  protected $dates = [];
  protected $fillable = ["geo","latlng","name"];
  protected $casts = ["latlng"=>"json"];
  public $events = [
    "saving"=>"App\\Events\\WaypointSavingEvent",
    "creating"=>"App\\Events\\WaypointCreatingEvent",
    "saved"=>"App\\Events\\WaypointSavedEvent"
  ];
  public function runs()
  {
    return $this->belongsToMany(Run::class);
  }
  public function getGeoAttribute()
  {
    return json_decode($this->attributes["geo"],true);
  }
  public function setGeoAttribute($value)
  {
    $this->attributes["geo"] = json_encode(json_decode(str_replace(["\n","\r","\t"],"",$value)));//just remove uneccessary spaces in the geocode result... takes less space huh
  }

    public function setNameAttribute($value){
      if(array_key_exists("geo",$this->attributes) && !empty($this->attributes["geo"]) && empty($value)){
        $this->attributes["name"]=$this->geo["address_components"][0]["short_name"];
      }
      else{
        $this->attributes["name"] = $value;
      }
    }
}
