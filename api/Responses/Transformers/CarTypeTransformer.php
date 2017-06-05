<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.03.2017
 * Time: 12:05
 */

namespace Api\Responses\Transformers;

use Dingo\Api\Contract\Http\Request;
use League\Fractal\TransformerAbstract;
use Lib\Models\Car;
use Lib\Models\CarType;

class CarTypeTransformer extends  TransformerAbstract
{
  public $availableIncludes = [
    "cars"
  ];
  public function transform(CarType $type)
  {
    return [
      "type"=>$type->name,
      "description"=>$type->description
    ];
  }
  public function includeCars(CarType $type)
  {
    return $this->collection($type->cars, new CarTransformer);
  }
}