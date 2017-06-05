<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:11
 */

namespace Api\Responses\Transformers;

use Dingo\Api\Contract\Http\Request;
use League\Fractal\ParamBag;
use League\Fractal\TransformerAbstract;
use Lib\Models\Car;

class CarTransformer extends TransformerAbstract
{
  public $availableIncludes = [
    "user"
  ];
  public $defaultIncludes = [
    "type"
  ];
  public function transform(Car $car)
  {
    
    return [
      "id"=>$car->id,
      "name"=>$car->name,
      "plate_number"=>$car->plate_number,
      "nb_place"=>$car->nb_place,
      "status"=>$car->status
    ];
  }
  public function includeType(Car $car)
  {
    return $this->item($car->car_type, new CarTypeTransformer);
  }
  public function includeUser(Car $car)
  {
    if($u = $car->user)
      return $this->item($u, new UserTransformer);
    else
      return $this->null();
  }
}