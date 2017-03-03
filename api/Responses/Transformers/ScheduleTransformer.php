<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 02.03.2017
 * Time: 17:06
 */

namespace Api\Responses\Transformers;


use App\Schedule;
use League\Fractal\TransformerAbstract;

class ScheduleTransformer extends TransformerAbstract
{
  public function transform(Schedule $schedule)
  {
    return array_merge($schedule->toArray(),[]);
  }
}