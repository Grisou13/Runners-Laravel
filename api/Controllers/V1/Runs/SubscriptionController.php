<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 10.03.2017
 * Time: 10:58
 */

namespace Api\Controllers\V1\Runs;


use Api\Controllers\BaseController;
use App\Http\Requests\UpdateRunSubscriptionRequest;
use Dingo\Api\Http\Request;
use Lib\Models\Car;
use Lib\Models\CarType;
use Lib\Models\Run;
use Lib\Models\RunSubscription;
use Lib\Models\User;

class SubscriptionController extends BaseController
{
  public function index(Run $run)
  {
    return $run->subscriptions;
  }
  public function store(Request $request, Run $run)
  {
    $sub = new RunSubscription;
    
    if($request->has("user"))
      $sub->user()->associate($request->get("user"));
    if($request->has("car"))
      $sub->car()->associate($request->get("car"));
    if($request->has("car_type"))
      $sub->car_type()->associate($request->get("car_type"));
    
    $sub->fill($request->except(["_token","token"]));
    $sub->run()->associate($run);
    $sub->save();
    return $this->response->created($content=$sub);
  }
  public function update(UpdateRunSubscriptionRequest $request, RunSubscription $sub)
  {
    //runners / users
    if($request->has("user"))
      if($request->get("user") == null)
        $sub->user()->dissociate();
      else
        $sub->user()->associate($request->get("user"));
    //cars
    if($request->has("car"))
      if($request->get("car") == null)
        $sub->car()->dissociate();
      else
        $sub->car()->associate($request->get("car"));
    //car types
    if($request->has("car_type"))
      if($request->get("car_type") == null)
        $sub->car_type()->dissociate();
      else
        $sub->car_type()->associate($request->get("car_type"));
    
    $data = $request->except(["token","_token","user","car_type","car"]);
    
    $sub->update($data);
    return $this->response->accepted($content=$sub);
  }
  public function delete(RunSubscription $sub)
  {
    $sub->delete();
  }
}