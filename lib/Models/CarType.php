<?php

namespace Lib\Models;
use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $fillable = [
        "name","description"
    ];
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    public function getRouteKeyName()
    {
      return 'name';
    }
    public function scopeFree()
    {
      return $this->whereHas("cars",function($q){
        $q->where("status","free");
      });
    }
}
