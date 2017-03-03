<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:27
 */

namespace Api\Responses\Transformers;


use League\Fractal\TransformerAbstract;
use App\Run;


class RunTransformer extends TransformerAbstract
{
  protected $availableIncludes = [
    "waypoints"
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
