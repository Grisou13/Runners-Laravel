<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 03.02.2017
 * Time: 12:01
 */

namespace Api\Requests\Filtering;

use Illuminate\Database\Eloquent\Builder;

class TypeFilterable extends StatusFilterable
{
  public function filterByType(Builder $query, $type)
  {
    if(empty($type))
      return $query;
    return $query->whereHas("type",function($q) use ($type){
      return $q->whereIn("type",explode(",",$type))->orWhereIn("id",explode(",",$type));
    });
  }
}