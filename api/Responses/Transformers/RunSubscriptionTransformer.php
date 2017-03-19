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
    return $this->item($sub->user, new UserTransformer);
  }
  public function includeCar(RunSubscription $sub)
  {
    return $this->item($sub->car, new CarTransformer);
  }
  public function includeVehiculeCategory(RunSubscription $sub)
  {
    return $this->item($sub->car_type, new CarTypeTransformer);
  }
}
