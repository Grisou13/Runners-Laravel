<?php

namespace Lib\Models;
use App\Concerns\StatusConcern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Status as StatusHelper;
class RunSubscription extends Model
{
    use StatusConcern, SoftDeletes, StatusConcern;
    public $table = "run_drivers";
    public $fillable = ["status","car_id","run_id","car_type_id","user_id"];
    public $hidden = ["id"];
    public static function boot()
    {
      parent::boot();
      self::saving(function(RunSubscription $self){
//        dump("-------------------------");
//        dump($self->has("car")->get()->first());
//        dump($self->has("user")->get()->first());
//        dump($self->doesntHave("car")->get()->first());
//        dump($self->doesntHave("user")->get()->first());
        
        if($self->car_id != null && $self->user_id !=null )
          $self->status = "ready_to_go";
        else if ( $self->car_id == null  && $self->user_id != null )
          $self->status = "missing_car";
        else if($self->user_id == null )
          $self->status="missing_user";
        else
          $self->status="needs_filling";
        
      });
    }
  
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
