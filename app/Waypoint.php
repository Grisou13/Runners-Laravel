<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waypoint extends Model
{
  protected $fillable = ["geo","latlng","name"];
  /**
   * Use the booting method to access eloquent Events, without using them in a seperate provider, or observer
   * The observer would be overkill, and putting in a provider not concise enough
   */
    protected static function boot(){
      parent::boot();
      static::creating(function($self){
        $self->latlng = json_encode(json_decode($self->geo)["geometry"]);
      });
    }
}
