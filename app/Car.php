<?php
/**
* User : Joël.DE-SOUSA
*/
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "plate_number","brand","model","color","nb_place","comment","stat","name"
    ];
    public function car_type()
    {
        return $this->belongsTo(CarType::class,$localKey="car_type_id");
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
