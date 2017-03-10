<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 03.03.2017
 * Time: 11:30
 */

namespace Api\Controllers\V1;

use Lib\Models\CarType;
use Lib\Models\Car;
use Lib\Models\User;
use Lib\Models\Run;
use Api\Controllers\BaseController;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
  public function fullText(Request $request, $model)
  {
    $klass = str_singular(studly_case($model)); //get the true model name
    $instance = new \ReflectionClass("App\\".$klass); //create reflection to instanciate it
    $instance = $instance->newInstance();
    $query = $instance->newQuery();
    $data = $request->except(["token","_token"]);
    foreach($data as $input => $val)
    {
      $query->where($input,"like","%{$val}%");
    }
    return $query->get();
  }
}