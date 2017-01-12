<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        "licence_plates","brand","model","color","seats","comment","comment","shortname"
    ];
    public function type()
    {
        return $this->hasOne(CarType::class);
    }
}
