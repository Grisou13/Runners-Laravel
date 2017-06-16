<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 28.04.2017
 * Time: 13:55
 */

namespace Lib\Concerns;


use Illuminate\Support\Collection;

trait CheckRoleTrait
{
  public function is($name)
  {
    return $this->roles->name == $name;
  }
  public function can($perms)
  {
    if(!is_array($perms) || $perms instanceof Collection)
      $perms = [$perms];
    return $this->roles()->whereHas("permissions",function($q) use ($perms){
      return $q->whereIn("permissions.name",$perms);
    })->count();
  }
  
}