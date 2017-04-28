<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 28.04.2017
 * Time: 13:55
 */

namespace Lib\Concerns;


trait CheckRoleTrait
{
  public function is($name)
  {
    return $this->roles->name == $name;
  }
  
}