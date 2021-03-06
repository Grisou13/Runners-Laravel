<?php
/**
* User : Joël.DE-SOUSA
*/
namespace Lib\Models;

use App\Concerns\StatusConcern;
use App\Helpers\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use Znck\Eloquent\Traits\BelongsToThrough;
use App\Contracts\StatusableContract;
class Car extends Model implements StatusableContract
{
    use SoftDeletes, BelongsToThrough, StatusConcern, ValidatingTrait;
    public $rules = [
      "car_type_id"=>"exists:car_types,id",
      "nb_place"=>"nullable"
    ];
    protected $fillable = [
        "plate_number","brand","model","color","nb_place","comment","name","status"
    ];
    public $events = [
      "saving"=>"App\\Events\\CarSavingEvent",
      "creating"=>"App\\Events\\CarCreatingEvent",
      "created"=>"App\\Events\\CarCreatedEvent"
    ];
    public function subscriptions()
    {
      return $this->hasMany(RunSubscription::class);
    }
    public function user()
    {
      $res = $this->subscriptions()->whereHas("user")->first();
      if($res)
        return $res->user;
      return null;
    }
    //shorthand
    public function getUserAttribute()
    {
      return $this->user();
    }
    public function type()
    {
      return $this->car_type();
    }
    public function car_type()
    {
        return $this->belongsTo(CarType::class,$localKey="car_type_id");
    }
    public function runs()
    {
      return $this->belongsToMany(Run::class, "run_drivers")->using(RunDriver::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    // public function setNameAttribute($value)
    // {
    //   $this->attributes["name"] = $this->car_type->name . " " . $value;
    // }
}
