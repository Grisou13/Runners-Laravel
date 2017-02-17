<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:28
 */

namespace App;


use App\Concerns\StatusConcern;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RunDriver
 * This model is used to link a run to a car and/or a car type, with a runner
 * @package App
 */
class RunDriver extends Model
{
  use StatusConcern;
  protected $fillable = ["status","car_id","user_id","run_id","car_type_id"];
  
  protected $primaryKey = false;
  protected $incrementing = false;
}