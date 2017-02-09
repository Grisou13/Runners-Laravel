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
    protected $dates = [
        "created_at",
        "updated_at",
        "start_at",
        "end_at"
    ];
    public function getNameAttribute()
    {
      if(array_key_exists("name",$this->attributes)){
        return $this->attributes["name"];
      }
      return "run to - ";
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
