<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1;


use Api\Controllers\BaseController;
use App\Run;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Http\Request;

class RunController extends BaseController
{
    public function index()
    {
        return Run::all();
    }
    public function show(Run $run)
    {
        return $run;
    }

    public function update(Request $request, Run $run)
    {
        $run->update($request->all());
        return $this->response()->accepted(route("api.runs.show",$run->id));
    }
    public function store(Request $request)
    {
        $run = new Run;
        $run->fill($request->all());
        $run->save();
        return $this->response()->created(route("api.runs.show",$run->id));
    }
    public function delete(Run $run)
    {
        return $run->delete();
    }
}