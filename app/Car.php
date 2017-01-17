<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        "plate_number","brand","model","color","nb_place","comment","name"
    ];
    public function type()
    {
        return $this->belongsTo(CarType::class);
    }
}
