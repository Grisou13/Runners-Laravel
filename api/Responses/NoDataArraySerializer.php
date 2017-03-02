<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 02.03.2017
 * Time: 14:18
 */

namespace Api\Responses;


use League\Fractal\Serializer\ArraySerializer;

class NoDataArraySerializer extends ArraySerializer
{
  /**
   * Serialize a collection.
   */
  public function collection($resourceKey, array $data)
  {
    return ($resourceKey) ? [ $resourceKey => $data ] : $data;
  }
  
  /**
   * Serialize an item.
   */
  public function item($resourceKey, array $data)
  {
    return ($resourceKey) ? [ $resourceKey => $data ] : $data;
  }
}