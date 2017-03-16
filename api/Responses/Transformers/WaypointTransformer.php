<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:26
 */

namespace Api\Responses\Transformers;

use League\Fractal\TransformerAbstract;
use Lib\Models\Waypoint;

class WaypointTransformer extends TransformerAbstract
{
  public function transform(Waypoint $point)
  {
    return [
      "nickname"=>$point->name,
      "geocoder"=>$point->geo
    ];
  }
}
