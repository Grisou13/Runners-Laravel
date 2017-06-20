<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 20.06.2017
 * Time: 10:55
 */

namespace Api\Responses;


use Illuminate\Contracts\Pagination\Paginator as IlluminatePaginatorInterface;
use League\Fractal\Resource\Collection as FractalCollection;
use Dingo\Api\Transformer\Adapter\Fractal as DingoFractalTransformer;

class FractalTransformer extends DingoFractalTransformer
{
  /**
   * Create a Fractal resource instance.
   *
   * @param  mixed $response
   * @param \League\Fractal\TransformerAbstract $transformer
   * @param array $parameters
   * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Item
   * @internal param $ \League\Fractal\TransformerAbstract
   */
  protected function createResource($response, $transformer, array $parameters)
  {
    if ($response instanceof IlluminatePaginatorInterface)
    {
      return new FractalCollection($response, $transformer, array_merge($parameters,['key'=>'data']));
    }
    
    return parent::createResource($response, $transformer, $parameters);
  }
}