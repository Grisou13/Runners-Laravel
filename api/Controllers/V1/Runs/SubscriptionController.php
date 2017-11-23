<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 10.03.2017
 * Time: 10:58
 */

namespace Api\Controllers\V1\Runs;


use Api\Controllers\BaseController;
use App\Events\RunSubscriptionUpdatedEvent;
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
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
  public function deleteAll(Run $run)
  {
    $run->subscriptions->each(function($s){$s->delete();});
    return $run;
  }
  public function join(Request $request, RunSubscription $sub)
  {
    if($sub->user_id == null)
      $sub->user()->associate($this->user()->id);
    else
      throw new UnauthorizedHttpException("Hey you can't go into a run if there already is someone there");
    return $sub;
  }
  public function unjoin(Request $request, RunSubscription $sub)
  {
    if($sub->user_id != null && $sub->user_id == $this->user()->id)
      $sub->user()->dissociate();
    else
      throw new UnauthorizedHttpException("Hey you can't leave a run for somebody else you little prick");
    return $sub;
  }
  public function store(CreateSubscriptionRequest $request, Run $run)
  {
    Log::debug("CREATING SUB => ".print_r($request->all(),true));
    $sub = new RunSubscription;
    //try and find the run in request or passed in path
    $sub->run()->associate($run);
    $sub->fill($request->except(["_token","token"]));
    if($request->has("user"))
    {
      $sub->user()->associate($request->get("user"));
//      if($this->user()->can("addOthersToSub",RunSubscription::class))
//        $sub->user()->associate($request->get("user"));
//      else
//        $sub->user()->associate($this->user());
//      $user = User::find($request->get("user"));
//      if($user->status == "free"){
//        $sub->user()->associate($user);
//      }
//      else{
//        Log::debug("trying to associate to run ({$run->id} {$run->status}) user ({$user->id} {$user->status}) that isn't free.");
//        throw new BadRequestHttpException("The user is ".$user->status. ", therefor you are not allowed to assign him");
//      }
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
      $sub->car()->associate($request->get("car"));
//      $car = Car::find($request->get("car"));
//      if($car->status == "free")
//        $sub->car()->associate($request->get("car"));
//      else{
//        Log::debug("trying to associate to run ({$run->id} {$run->status}) car ({$car->id} {$car->status}) that isn't free");
//        throw new BadRequestHttpException("The car is ".$car->status. ", therefor, you are not allowed to use it");
//      }
    }
    if($request->has("car_type"))
      $sub->car_type()->associate($request->get("car_type"));

    $sub->save();
    return $sub;
  }
  public function update(UpdateRunSubscriptionRequest $request, Run $run, RunSubscription $sub)
  {
    //TODO handle permissions to check if user is allowed to dissociate from run (if driver can only remove himself and not somebody else)
    
    //runners / users
    if($request->exists("user")) {
      if ($request->get("user") == null)
        $sub->user()->dissociate();
      else if(RunSubscription::where("run_id",$run->id)->where("user_id", $request->get("user"))->count() <= 0) // the user is registered once
        $sub->user()->associate($request->get("user"));
      else
        throw new BadRequestHttpException("The user you enetered is already in a convoy");
    }
    //cars
      if($request->exists("car")) {
          //check if user can associate anybody
          if ($this->auth()->user()->hasAnyRole(["coordinator", "admin"])) { //TODO hard coded permissions
              if ($request->get("car") == null)
                  $sub->car()->dissociate();
              else if(RunSubscription::where("run_id",$sub->run_id)->where("car_id", $request->get("car"))->count() <= 0) // the car is registered once
                  $sub->car()->associate($request->get("car"));
              else
                  throw new BadRequestHttpException("The car you enetered is already in a convoy");

          } //otherwise check if it's his subscription
          else if ($sub->user_id == $this->auth()->user()->id) {
              dd("YOU ARE THE USER");
              if ($request->get("car") == null)
                  $sub->car()->dissociate();
              else if(RunSubscription::where("run_id",$sub->run_id)->where("car_id", $request->get("car"))->count() <= 0) // the car is registered once
                  $sub->car()->associate($request->get("car"));
              else
                  throw new BadRequestHttpException("The car you enetered is already in a convoy");

          }
      }
    //car types
    if($request->exists("car_type")) {
      if ($request->get("car_type") == null)
        $sub->car_type()->dissociate();
      else
        $sub->car_type()->associate($request->get("car_type"));
    }
    $data = $request->except(["token","_token","user","car_type","car"]);
    $sub->update($data);
    broadcast(new RunSubscriptionUpdatedEvent($sub));
    return $sub;
  }
  public function delete(RunSubscription $sub)
  {
    $sub->delete();
    return $sub;
  }
  public function stop(RunSubscription $sub)
  {
    $sub->status="finished";
    $sub->ended_at = Carbon::now();
    $sub->save();
    return $sub;
  }
  public function start(RunSubscription $sub)
  {
    $sub->status="gone";
    $sub->started_at = Carbon::now();
    $sub->save();
    return $sub;
  }
}
