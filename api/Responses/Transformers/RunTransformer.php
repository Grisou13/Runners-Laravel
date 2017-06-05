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
      "status"=>$run->status,
      "nb_passenger"=>$run->nb_passenger,
      "note"=>$run->note,
      "title"=>$run->name,
      "begin_at"=>$run->planned_at ? (string)$run->planned_at : null,
      "start_at"=>$run->planned_at ? (string)$run->started_at : null,
      "end_at"=>$run->planned_at ? (string)$run->ended_at : null,
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
