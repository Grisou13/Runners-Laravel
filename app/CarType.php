<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
{
    protected $fillable = [
        "type","description"
    ];
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
