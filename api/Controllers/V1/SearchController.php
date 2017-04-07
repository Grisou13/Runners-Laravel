<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 03.03.2017
 * Time: 11:30
 */

namespace Api\Controllers\V1;

use Api\Requests\SearchRequest;
use Lib\Models\CarType;
use Lib\Models\Car;
use Lib\Models\User;
use Lib\Models\Run;
use Api\Controllers\BaseController;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
  protected $models = [
    "users",
    "cars",
    "runs",
    "waypoints"
  ];
  public function fullText(Request $request, $model)
  {
    $klass = str_singular(studly_case($model)); //get the true model name
    $instance = new \ReflectionClass("Lib\\Models\\".$klass); //create reflection to instanciate it
    $instance = $instance->newInstance();
    $query = $instance->newQuery();
    $data = $request->except(["token","_token"]);
    foreach($data as $input => $val)
    {
      $query->where($input,"like","%{$val}%");
    }
    return $query->get();
  }
  public function globalSearch(SearchRequest $request)
  {
    $query = $request->get("q");
    $res = [];
    //search all the models
    foreach($this->models as $m)
      $res[$m] = $this->api->get("/api/$m/search",["q"=>$query]);
    
    return $res;
  }
}