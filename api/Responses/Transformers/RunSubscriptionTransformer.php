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
use Lib\Models\RunSubscription;

class RunSubscriptionTransformer extends TransformerAbstract
{
  protected $defaultIncludes = [
    "user",
    "car",
    "vehicle_category",
  ];
  protected $availableIncludes = [
    "run"
  ];
  public function transform(RunSubscription $sub)
  {
    return [
      "id"=>$sub->id,
      "status"=>$sub->status,
      "started_at"=>(string)$sub->started_at,
      "ended_at"=>(string)$sub->ended_at,
      "run_id"=>$sub->run_id
    ];
  }
  public function includeRun(RunSubscription $sub)
  {
    return $this->item($sub->run, new RunTransformer);
  }
  public function includeUser(RunSubscription $sub)
  {
    if($u = $sub->user)
      return $this->item($u, new UserTransformer);
    return $this->null();
  }
  public function includeCar(RunSubscription $sub)
  {
    if($c = $sub->car)
      return $this->item($c, new CarTransformer);
    return $this->null();
  }
  public function includeVehicleCategory(RunSubscription $sub)
  {
    if($c = $sub->car_type)
      return $this->item($c, new CarTypeTransformer);
    return $this->null();
  }
}
