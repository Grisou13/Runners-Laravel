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

class RunTransformer extends TransformerAbstract
{
  protected $defaultIncludes = [
    "waypoints",
    "runners"
  ];
  public function transform(Run $run)
  {
    return [
      "id"=>$run->id,
      "nb_passenger"=>$run->nb_passenger,
      "title"=>$run->name,
      "begin_date"=>$run->planned_at,
      "start_at"=>$run->started_at,
      "end_at"=>$run->ended_at,
    ];
  }
  public function includeRunners(Run $run)
  {
    return $this->collection($run->runners, new RunSubscriptionTransformer);
  }
  public function includeWaypoints(Run $run)
  {
    return $this->collection($run->waypoints, new WaypointTransformer);
  }
}
