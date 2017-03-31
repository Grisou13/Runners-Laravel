<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 10.03.2017
 * Time: 10:58
 */

namespace Api\Controllers\V1\Runs;


use Api\Controllers\BaseController;
use App\Http\Requests\CreateRunSubscription;
use App\Http\Requests\UpdateRunSubscriptionRequest;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Log;
use Lib\Http\Requests\CreateSubscriptionRequest;
use Lib\Http\Requests\CreateSubscriptionWithoutRunInRequest;
use Lib\Models\Car;
use Lib\Models\CarType;
use Lib\Models\Run;
use Lib\Models\RunSubscription;
use Lib\Models\User;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class SubscriptionController extends BaseController
{
  public function show(Request $request, RunSubscription $sub)
  {
    return $sub;
  }
  public function index(Request $request,Run $run)
  {
      return $run->subscriptions;
  }

  public function store(CreateSubscriptionRequest $request, Run $run)
  {
    $sub = new RunSubscription;
    //try and find the run in request or passed in path
    $sub->run()->associate($run);
    $sub->fill($request->except(["_token","token"]));
    if($request->has("user"))
    {
      $user = User::find($request->get("user"));
      if($user->status == "free"){
        $sub->user()->associate($user);
      }
      else{
        Log::debug("trying to associate to run ({$run->id} {$run->status}) user ({$user->id} {$user->status}) that isn't free.");
        throw new BadRequestHttpException("The user is ".$user->status. ", therefor you are not allowed to assign him");
      }
    }
//    else
//    {
//      $user = $this->auth->user();
//      if($user->status == "free")
//        $sub->user()->associate($user);
//      else
//        Log::debug("trying to associate to run ({$run->id} {$run->status}) user ({$user->id} {$user->status}) that isn't free");
//    }
    if($request->has("car"))
    {
      $car = Car::find($request->get("car"));
      if($car->status == "free")
        $sub->car()->associate($request->get("car"));
      else{
        Log::debug("trying to associate to run ({$run->id} {$run->status}) car ({$car->id} {$car->status}) that isn't free");
        throw new BadRequestHttpException("The car is ".$car->status. ", therefor, you are not allowed to use it");
      }
        
    }
    elseif($request->has("car_type"))
      $sub->car_type()->associate($request->get("car_type"));
    
    $sub->save();
    return $sub;
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
    return $sub;
  }
  public function delete(RunSubscription $sub)
  {
    
    $sub->delete();
  }
}