<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1\Runs;

use Api\Controllers\BaseController;
use Api\Requests\ListRunRequest;
use App\Http\Requests\CreateRunRequest;
use Carbon\Carbon;
use Lib\Models\Run;
use Lib\Models\RunSubscription;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Http\Request;
use Api\Responses\Transformers\RunTransformer;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class RunController extends BaseController
{
    public function index(ListRunRequest $request)
    {
      $query = new Run;
      $query = $query->newQuery();
      if($request->has("status"))
        $query->ofStatus($request->get("status"));
      return $this->response()->collection($query->get(), new RunTransformer);
    }
    public function show(Request $request, Run $run)
    {
      return $run;
    }

    public function update(Request $request, Run $run)
    {
        $run->update($request->all());
        return $this->response()->accepted();
    }
    public function store(CreateRunRequest $request)
    {
        $run = new Run;
        $subs = [];
        
        foreach($request->get("convoys",[]) as $convoy)
        {
          $userId = array_key_exists("user",$convoy) ? $convoy["user"] : null;
          $carId = array_key_exists("car",$convoy) ? $convoy["car"] : null;
          $carTypeId = array_key_exists("car_type",$convoy) ? $convoy["car_type"] : null;
          $sub = new RunSubscription;
          $sub->user()->associate($userId);
          $sub->car()->associate($carId);
          $sub->car_type()->associate($carTypeId);
          $subs[] = $sub;
        }
        
        $run->fill($request->except(["_token","token"]));
        $run->name =  $request->get("title",$request->get("artist"));

        $run->save();
        //save relationships
        if(count($subs))
          $run->subscriptions()->saveMany($subs);
        foreach($request->get("waypoints") as $point)
          $run->waypoints()->attach($point);
        
      return $run;
      //return $this->response->item($run, new RunTransformer);
        //return $this->response()->created($content=$run);
    }
    public function destroy(Run $run)
    {
        $run->ended_at = Carbon::now();
        $run->save();
        $run->delete();
        return $run;
    }
    public function start(Request $request,Run $run)
    {
      //check all subscriptions if they are good
        foreach($run->subscriptions as $sub)
        {
            if(!$sub->has("car") && $sub->has("user"))
               throw new NotAcceptableHttpException("All runners have not been filled, please fill run subscription $sub->id");
        }
        $run->started_at = Carbon::now();
        return $run;

    }
    public function stop(Request $request, Run $run)
    {
      $run->ended_at = Carbon::now();
      $run->save();
      $run->delete();//deleting the model will populate ended_at field, and archive it
      return $run;
    }
}
