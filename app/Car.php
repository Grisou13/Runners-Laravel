<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        "plate_number","brand","model","color","nb_place","comment","stat","name"
    ];
    public function type()
    {
        return $this->belongsTo(CarType::class,$localKey="car_type_id");
    }
}
