<?php

namespace App;

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
    $this->attributes["geo"] = str_replace(["\n","\r","\t"],"",$value);//just remove uneccessary spaces in the geocode result... takes less space huh
  }
  /**
   * Use the booting method to access eloquent Events, without using them in a seperate provider, or observer
   * The observer would be overkill, and putting in a provider not concise enough
   */
    protected static function boot(){
      parent::boot();
      static::creating(function($self){
        \Log::debug($self->geo);
        \Log::debug($self->geo["geometry"]["location"]);
        $self->latlng = $self->geo["geometry"]["location"];
      });
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
