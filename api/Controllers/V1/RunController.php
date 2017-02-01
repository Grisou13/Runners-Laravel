<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1;


use Api\Controllers\BaseController;
use Api\Requests\Filtering\RequestFilter;
use App\Run;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Http\Request;
use Unlu\Laravel\Api\QueryBuilder;

class RunController extends BaseController
{
    public function index(Request $request)
    {
      $queryBuilder = new RequestFilter(new Run, $request);
      if($request->has("page") || $request->has("limit"))
        return $queryBuilder->build()->paginate();
      return $queryBuilder->build()->get();
    }
    public function show(Request $request, Run $run)
    {
      $queryBuilder = new RequestFilter($run, $request);
      //return $user;
      $user = $queryBuilder->build()->get();
      if($user->count() != 1)//just in case something happens during the querying of the model
        throw new HttpException("sorry bru");
      return $user->first();//we need to get the index 0, since RequestFilter can only use a global query ->returns a list of 1 item
    }

    public function update(Request $request, Run $run)
    {
        $run->update($request->all());
        return $this->response()->accepted();
    }
    public function store(Request $request)
    {
        $run = new Run;
        $run->fill($request->all());
        $run->save();
        return $this->response()->created();
    }
    public function delete(Run $run)
    {
        return $run->delete();
    }
}