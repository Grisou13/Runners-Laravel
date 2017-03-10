<?php
/**
* User : Joël.DE-SOUSA
*/
namespace Lib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "plate_number","brand","model","color","nb_place","comment","name"
    ];

    public function runners()
    {
      return $this->hasManyThrough(User::class, RunDriver::class);
    }
    public function car_type()
    {
        return $this->belongsTo(CarType::class,$localKey="car_type_id");
    }
    public function runs()
    {
      return $this->hasManyThrough(Run::class, RunDriver::class,
                                  "id","id","id");
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function setNameAttribute($value)
    {
      return $this->attributes["name"] = $this->car_type->name . " " . $value;
    }
}
