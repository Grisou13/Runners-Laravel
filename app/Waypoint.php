<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Waypoint extends Model
{
  use SoftDeletes, ValidatingTrait;
  public $rules = [
    "name"=>"required_without:geo",
    "geo"=>"required_without:name"
  ];
  protected $fillable = ["geo","latlng","name"];
  protected $casts = ["geo"=>"json","latlng"=>"json"];
  public function runs()
  {
    return $this->belongsToMany(Run::class);
  }
  /**
   * Use the booting method to access eloquent Events, without using them in a seperate provider, or observer
   * The observer would be overkill, and putting in a provider not concise enough
   */
    protected static function boot(){
      parent::boot();
      static::creating(function($self){
        $self->latlng = $self->geo["geometry"];
      });
    }
    public function setNameAttribute($value){
      if(array_key_exists("geo",$this->attributes) && empty($value)){
        $this->attributes["name"]=$this->geo["address_components"][0]["short_name"];
      }
      else{
        $this->attributes["name"] = $value;
      }
    }
}
