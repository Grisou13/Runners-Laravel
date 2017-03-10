<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:27
 */

namespace Api\Responses\Transformers;

use League\Fractal\TransformerAbstract;
use Lib\Models\Run;

class RunSubscriptionTransformer extends TransformerAbstract
{
  protected $availableIncludes = [
    "user",
    "car",
    "car_type",
    "run"
  ];
  public function transform(Run $run)
  {
    return array_merge($run->toArray(),[]);
  }
  public function includeWaypoints(Run $run)
  {
    return $this->collection($run->waypoints, new WaypointTransformer);
  }
}
