<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:11
 */

namespace Api\Responses\Transformers;

use League\Fractal\TransformerAbstract;
use Lib\Models\Car;

class CarTransformer extends TransformerAbstract
{
  public function transform(Car $car)
  {
    return array_merge($car->toArray(),[]);
  }
}