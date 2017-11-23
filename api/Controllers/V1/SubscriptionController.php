<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 10.03.2017
 * Time: 10:58
 */

namespace Api\Controllers\V1;


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
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class SubscriptionController extends BaseController
{
  /**
   * @var RunSubscription
   */
  private $subscription;

  /**
   * SubscriptionController constructor.
   * @param RunSubscription $subscription
   */
  public function __construct(RunSubscription $subscription)
  {
    $this->subscription = $subscription;
  }

  public function show(Request $request, RunSubscription $sub)
  {
    return $sub;
  }
  public function index(Request $request, Run $run)
  {
      return $this->subscription->newQuery()->get();
  }

  public function store(CreateSubscriptionRequest $request)
  {
    $sub = $this->subscription;
    //try and find the run in request or passed in path
    $run = Run::find($request->get("run"));
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
    // dd($request->get("user") == null);

    //runners / users
      //TODO check if user can update the subscription and add other users
    if($request->exists("user")){
      if($request->get("user") == null){
        $sub->user()->dissociate();
      }
      else if(RunSubscription::where("run_id",$sub->run_id)->where("user_id", $request->get("user"))->count() <= 0) // the user is registered once
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
    if($request->exists("car_type"))
      if($request->get("car_type") == null)
        $sub->car_type()->dissociate();
      else
        $sub->car_type()->associate($request->get("car_type"));

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
}
