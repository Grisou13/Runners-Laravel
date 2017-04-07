<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Dingo\Api\Routing\UrlGenerator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Helpers;
    protected $uselessRequestFields = ["_token"];
    protected function toApiRoute($method, $route = null, $models = null, $data = null, $version = "v1")
    {
//        if($route == null)
//        {
//            $routeSuffix = "";
//            switch ($method)
//            {
//                case "patch":
//                case "put":
//                    $routeSuffix = "update";
//                    break;
//                case "post":
//                    $routeSuffix = "store";
//                    break;
//                case "get":
//                    $routeSuffix = "index";
//                    if ($model != null)
//                        $routeSuffix = "show";
//                    break;
//            }
//            if($model != null)
//            {
//                $routePrefix = str_plural(strtolower(get_class($model)));
//            }
//            else
//            {
//                throw new \Exception("You need to provide a model, or a complete route name for routing");
//            }
//            $route = $routePrefix.".".$routeSuffix;
//        }
        if($data == null)
        {
            $capture = Request::capture();
            $data = $capture->except($this->uselessRequestFields);
        }
        else
        {
            if($data instanceof Request)
                $data = $data->except($this->uselessRequestFields);
            elseif($data instanceof Collection)
                $data = $data->toArray();
            elseif(!in_array(\Countable::class,class_implements($data)))//check if not an array
                throw new \Exception("Data should be an array, collection, or request instance");
        }

        return $this->api->{$method}(app(UrlGenerator::class)->version($version)->route($route, $models))->with($data)->be(Auth::user());
    }
    protected function toApiUrl($method, $url, $data)
    {
        if($data instanceof Request)
        {
            $data = $data->excpet(["_token"]);
        }
        return $this->api->{$method}($url)->with($data->except($this->uselessRequestFields));
    }
    protected function rerouteRequest(Request $request, $version = "v1")
    {
      $method = $request->method();
      
      $data = $request->all();
      //$token = Auth::user()->getAccessToken();
      $url = $request->path();
      return $this->api->{$method}($url)->version($version)->with($data)->be(Auth::user());

    }
}
