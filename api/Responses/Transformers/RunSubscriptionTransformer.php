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
      "status"=>"SOMETHING"
    ];
  }
  public function includeUser(RunSubscription $sub)
  {
    if($sub->user)
      return $this->item($sub->user, new UserTransformer);
    return null;
  }
  public function includeCar(RunSubscription $sub)
  {
    if($sub->car)
      return $this->item($sub->car, new CarTransformer);
    return null;
  }
  public function includeVehiculeCategory(RunSubscription $sub)
  {
    if($sub->car_type)
      return $this->item($sub->car_type, new CarTypeTransformer);
    return null;
  }
}
