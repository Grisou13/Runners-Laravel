<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1;

use Api\Requests\SearchRequest;
use App\Helpers\Status;
use App\Http\Requests\CreateCarTypeRequest;
use App\Http\Requests\CreateCommentRequest;
use Api\Requests\ListCarRequest;
use Lib\Models\Car;
use Lib\Models\CarType;
use Lib\Models\User;
use Lib\Models\Comment;
use Api\Controllers\BaseController;
use App\Http\Requests\CreateCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CarTypeController extends BaseController
{
    public function carList(CarType $type)
    {
      return $type->cars;
    }
    public function search(SearchRequest $request)
    {
      $query = $request->get("q","");
      return CarType::where("name","like","%$query%")->get();
    }
    public function index(Request $request)
    {

      $type = new CarType;
      $query = $type->newQuery();
      if($request->has("status"))
      {
        $status = $request->get("status");
        $query->whereHas("cars",function($q) use ($status){
          return $q->where("status",$status);
        });
      }

      return $query->get();
      
    }
    public function show(Request $request, CarType $type)
    {
      return $type;
    }

    public function update(UpdateCarRequest $request, CarType $type)
    {
        $type->update($request->all());
        $type->save();
        return $this->response()->accepted();
    }
    public function store(CreateCarTypeRequest $request)
    {
        $type = new CarType;
        $type->fill($request->all());
        $type->save();
        return $this->response()->created();
    }
    public function delete(CarType $type)
    {
        return $type->delete();
    }
    
}
