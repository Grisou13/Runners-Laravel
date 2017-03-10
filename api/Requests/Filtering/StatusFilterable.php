<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 03.02.2017
 * Time: 11:41
 */

namespace Api\Requests\Filtering;


use Illuminate\Database\Eloquent\Builder;

class StatusFilterable extends RequestFilter
{
  public function filterByStatus(Builder $query, $status)
  {
    if(empty($status)){
      return $query;
    }
    return $query->whereHas("status",function($q) use ($status){
      return $q->whereIn("name",explode(",",$status));
    });
    
  }
}