<?php

namespace Lib\Models;
use App\Concerns\StatusConcern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RunSubscription extends Model
{
    use StatusConcern, SoftDeletes;
    public $table = "run_drivers";
    public $fillable = ["status","car_id","run_id","car_type_id","user_id"];
    public $hidden = ["id"];
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
