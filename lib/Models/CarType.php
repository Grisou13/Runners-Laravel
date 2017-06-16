<?php

namespace Lib\Models;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $fillable = [
        "name","description","nb_place"
    ];
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    public function getRouteKeyName()
    {
      return 'name';
    }
    public function setNameAttribute($val){
      $this->attributes["name"] = strtoupper($val);
    }
    public function scopeFree()
    {
      return $this->whereHas("cars",function($q){
        $q->where("status","free");
      });
    }
}
