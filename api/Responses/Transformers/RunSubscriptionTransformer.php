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
    "vehicule_category",
  ];
  protected $availableIncludes = [
    "run"
  ];
  public function transform(RunSubscription $sub)
  {
    return [
      "status"=>$sub->status
    ];
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
  public function includeVehiculeCategory(RunSubscription $sub)
  {
    if($c = $sub->car_type)
      return $this->item($c, new CarTypeTransformer);
    return $this->null();
  }
}
