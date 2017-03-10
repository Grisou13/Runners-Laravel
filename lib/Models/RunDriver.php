<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:28
 */

namespace Lib\Models;

use App\Concerns\StatusConcern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class RunDriver
 * This model is used to link a run to a car and/or a car type, with a runner
 * @package App
 */
class RunDriver extends Pivot
{

  public $table = "run_drivers";
  public $fillable = ["status","car_id","run_id","car_type_id","user_id"];
  public $hidden = ["id"];
//
//  protected $fillable = ["status","car_id","user_id","run_id","car_type_id"];
//
//  protected $primaryKey = false;
//  protected $incrementing = false;
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
