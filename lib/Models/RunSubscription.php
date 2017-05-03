<?php

namespace Lib\Models;
use App\Concerns\StatusConcern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Status as StatusHelper;
class RunSubscription extends Model
{
    use StatusConcern, SoftDeletes, StatusConcern, TransformableModel;
    public $table = "run_drivers";
    public $fillable = ["car_id","run_id","car_type_id","user_id"];
    public $hidden = ["id"];
    protected $touches = [
      "run"
    ];
    protected $events = [
      "saving"=>"App\\Events\\RunSubscriptionSavingEvent",
      "saved"=>"App\\Events\\RunSubscriptionSavedEvent",
      "created"=>"App\\Events\\RunSubscriptionCreatedEvent",
      "updated"=>"App\\Events\\RunSubscriptionUpdatedEvent",
      "deleting"=>"App\\Events\\RunSubscriptionDeletingEvent",
      "deleted"=>"App\\Events\\RunSubscriptionDeletedEvent"
    ];
  
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function car_type()
    {
        return $this->belongsTo(CarType::class);
    }
    public function run()
    {
        return $this->belongsTo(Run::class);
    }
    
}
