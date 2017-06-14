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
use Api\Requests\SearchRequest;
use App\Events\RunDeletedEvent;
use App\Events\RunStartedEvent;
use App\Events\RunStoppedEvent;
use App\Events\RunSubscriptionCreatedEvent;
use App\Events\RunSubscriptionDeletedEvent;
use App\Events\RunSubscriptionSavedEvent;
use App\Events\RunSubscriptionUpdatedEvent;
use App\Events\RunUpdatedEvent;
use App\Http\Requests\CreateRunRequest;
use App\Http\Requests\PublishRunRequest;
use Carbon\Carbon;
use Lib\Models\Run;
use Lib\Models\RunSubscription;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Http\Request;
use Api\Responses\Transformers\RunTransformer;
use Lib\Models\Waypoint;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class RunController extends BaseController
{
  /**
   * Retrieve all runs
   * @param ListRunRequest $request
   * @return \Dingo\Api\Http\Response
   */
    public function index(ListRunRequest $request)
    {
      $query = new Run;
      $query = $query->newQuery();
      if($request->has("between")) {
//        $dates = explode(",",$request->get("between"));
//        $query->whereBetween("planned_at", $dates);
        $t = explode(",",$request->get("between"));
        $start = trim($t[0]);
        $end = trim($t[1]);
        $query->where("planned_at",">=",$start)->where("planned_at", "<",$end);
      }
      if($request->has("actif"))
        $query->actif();//retrive all active runs @see Lib\Models\Run::scopeActif
      if($request->has("status"))
        $query->ofStatus($request->get("status"));
      if($request->has("sortBy")){
          $sorts = explode(",",$request->get("sortBy"));
          foreach($sorts as $sort){
              $t = explode(":",$sort);
              $column = trim($t[0]);
              if(count($t)==2)
                  $sorting = trim($t[1]);
              else
                  $sorting = "ASC";//default sorting
              $query->orderBy($column,$sorting);
          }
      }
      //we filter the status finished=false, otherwise we don't need
      if( ! (int) filter_var($request->get("finished",false), FILTER_VALIDATE_BOOLEAN)) {
        $query->notOfStatus("finished");
      }
      return $this->response()->collection($query->get(), new RunTransformer);
    }
  
  /**
   * Allows searching runs by name, maybe more in the future
   * @param SearchRequest $request
   * @return mixed
   */
    public function search(SearchRequest $request)
    {
      $query = $request->get("q","");
      return Run::where("name","like","%$query%")->get();
    }
  
  /**
   * Display a basic representation of a run @see RunTransformer
   * @param Request $request
   * @param Run $run
   * @return Run
   */
    public function show(Request $request, Run $run)
    {
      return $run;
    }
  
  /**
   * Update a run
   * @param Request $request
   * @param Run $run
   * @return Run
   */
    public function update(Request $request, Run $run)
    {
        $run->fill($request->all());
        $run->save();
        $this->prepareSubscriptionsFromRequest($request, $run);
        $this->prepareWaypointsFromRequest($request, $run);
        
        // broadcast(new RunUpdatedEvent($run));

        return $run;
    }
  
  /**
   * Attaches waypoints to a run
   * @param Request $request
   * @param Run $run
   */
    protected function prepareWaypointsFromRequest(Request $request, Run $run)
    {
      if($request->has("waypoints")) {
        if($run->exists)//remove all waypoints and reassign them
          $run->waypoints()->sync([]);
        foreach($request->get("waypoints") as $point){
          if(empty($point)) continue;
          $run->waypoints()->attach(Waypoint::firstOrCreate(["name"=>$point]));
        }
      }
    }
  /**
   * Attaches subscriptions from request to a run
   * This returns an array of new subscriptions. These should be saved in the future since the run might need to be completed
   * @param Request $request
   * @param $run
   * @return Run $run
   */
    protected function prepareSubscriptionsFromRequest(Request $request, $run)
    {

      if($request->has("runners"))
        $subscriptions = $request->get("runners",[]);
      else
        $subscriptions = $request->get("subscriptions",[]);
      
//      $t = collect($request->get("subscriptions", []));
      //reset the subscriptions of a run
      $run->subscriptions()->whereNotIn("id",collect($subscriptions)->pluck("id")->filter())->get()->each(function(RunSubscription $sub){
        // if(!$t->contains("id",$sub->id))
        $sub->forceDelete();
      });
  
      foreach ($subscriptions as $convoy) {
        $userId = array_key_exists("user", $convoy) ? $convoy["user"] : null;
        $carId = array_key_exists("car", $convoy) ? $convoy["car"] : null;
        $carTypeId = array_key_exists("car_type", $convoy) ? $convoy["car_type"] : null;
        $sub = array_key_exists("id", $convoy) ? RunSubscription::findOrFail($convoy["id"]) : new RunSubscription;
        $sub->user()->associate($userId);
        $sub->car()->associate($carId);
        $sub->car_type()->associate($carTypeId);
        if($sub->exists) {
          $sub->save();
          broadcast(new RunSubscriptionUpdatedEvent($sub));
        }
        else{
          $sub->run()->associate($run);
          $sub->save();
//          $subs[] = $sub;
        }
      }
      return $run;
    }
  
  /**
   * Creates a new run, this run is considered as "drafting"
   * @param CreateRunRequest $request
   * @return Run
   */
    public function store(CreateRunRequest $request)
    {
        $run = new Run;
        $run->fill($request->except(["_token","token"]));
        if($run->name == null)
          $run->name =  $request->get("title",$request->get("artist", null));
        
        $run->save();
        $this->prepareSubscriptionsFromRequest($request, $run);
        $this->prepareWaypointsFromRequest($request, $run);
        
      return $run;
      //return $this->response->item($run, new RunTransformer);
      //return $this->response()->created($content=$run);
    }
    public function publish(PublishRunRequest $request, Run $run)
    {
      $run->fill($request->except(["_token","token"]));
      $this->prepareSubscriptionsFromRequest($request, $run);
      $this->prepareWaypointsFromRequest($request, $run);
      
      if($run->runners()->where(function($query){
        return $query->whereNotNull("car_id")->orWhereNotNull("car_type_id");
        })->count() >= 1)
        $run->publish();
      else
        throw new UnprocessableEntityHttpException("The run needs to have atleast one car type, or car to publish the run");
      return $run;
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
        if(!$this->user()->hasPermissionTo("force run start") && $run->status != "ready")
          throw new UnauthorizedHttpException("Not every convoy has been assigned");
//        $seats = $run->subscriptions->map(function($sub){
//          return $sub->car->nb_place;
//        })->sum();
//        if($seats < $run->nb_passenger)
//          throw new NotAcceptableHttpException("The run cannot start because number you don't have enough seats avaiable ($seats) in cars (needed : {$run->nb_passenger} )");
        $run->started_at = Carbon::now();
        $run->status="gone";
        $run->subscriptions->each(function($sub) use($run){
          $sub->status = "gone";
          $sub->started_at = $run->started_at;
          $sub->save();
        });
        $run->save();
      //TODO: rethink where to put this event
      //notify the run has started, this will triger observers that will put every utalised car and runner on "gone" status
        broadcast(new RunStartedEvent($run))->toOthers();
        // event(new RunUpdatedEvent($run));
        return $run;

    }
    protected function terminateRun(Run $run){
      $run->ended_at = Carbon::now();
      $run->status="finished";
      $run->subscriptions->each(function($sub){
        $sub->status = "finished";
        $sub->ended_at = Carbon::now();
        $sub->save();
        $sub->delete();
        event(new RunSubscriptionDeletedEvent($sub));
      });
      \Log::debug("RUN STOPPED: status:".$run->status);
  
      $run->save();
      \Log::debug("RUN STOPPED: status:".$run->status);
      event(new RunStoppedEvent($run));
      // event(new RunUpdatedEvent($run));
      // $run->delete();
    }
    public function stop(Request $request, Run $run)
    {
      $user = $this->user();

      if(!$user->hasPermissionTo("end run"))
        throw new UnauthorizedHttpException("You are not allowed to finish a run");

      if($user->hasPermissionTo("force run end"))
        $this->terminateRun($run);
      else{
        $sub = $run->subscriptions()->whereHas("user",function($q) use($user){return $q->where("users.id",$user->id);})->first();
        if($sub != null)
        {
          $sub->status = "finished";
          $sub->save();
        }
        if($run->subscriptions()->ofStatus("finished")->count() == $run->subscriptions()->count())
          $this->terminateRun($run);
      }
      broadcast(new RunStoppedEvent($run))->toOthers();
      return $run;
    }
}
