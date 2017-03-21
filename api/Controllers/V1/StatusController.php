<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 03.03.2017
 * Time: 10:46
 */

namespace Api\Controllers\V1;

use Api\Controllers\BaseController;
use Dingo\Api\Http\Request;


class StatusController extends BaseController
{
  public function index()
  {
    return config("status");
  }
  public function model(Request $request)
  {
      return config("status.".$request->get("model"));
//    $klass = str_singular(studly_case($model)); //get the true model name
//    $instance = new \ReflectionClass("Lib\\Models\\".$klass); //create reflection to instanciate it
//    $instance = $instance->newInstance();
//    $query = $instance->newQuery();
//    $data = $request->except(["token","_token"]);
//    foreach($data as $input => $val)
//    {
//      $query->where($input,"like","%{$val}%");
//    }
//    return $query->get();
  }
}