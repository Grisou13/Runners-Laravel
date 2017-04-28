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
use App\Events\RunStartedEvent;
use App\Http\Requests\CreateRunRequest;
use Carbon\Carbon;
use Lib\Models\Run;
use Lib\Models\RunSubscription;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Http\Request;
use Api\Responses\Transformers\RunTransformer;
use Lib\Models\Waypoint;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RunController extends BaseController
{
    public function index(ListRunRequest $request)
    {
      $query = new Run;
      $query = $query->newQuery();
      if($request->has("between")) {
        $dates = explode(",",$request->get("between"));
        $query->whereBetween("planned_at", $dates);
      }
      else
      $query->actif();//retrive all active runs @see Lib\Models\Run::scopeActif
      if($request->has("status"))
        $query->ofStatus($request->get("status"));
      return $this->response()->collection($query->get(), new RunTransformer);
    }
    public function search(SearchRequest $request)
    {
      $query = $request->get("q","");
      return Run::where("name","like","%$query%")->get();
    }
    public function show(Request $request, Run $run)
    {
      return $run;
    }

    public function update(Request $request, Run $run)
    {

        $run->update($request->all());
        if($request->has("waypoints"))
        {
          $run->waypoints()->detach();//remove all waypoints and reassign them
          $run->waypoints()->attach($request->get("waypoints"));
        }

        $run->save();
        return $run;
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

        foreach($request->get("waypoints") as $point){
          $point = Waypoint::firstOrNew(["id"=>$point],["name"=>$point]);
          if($point->exists())
            $run->waypoints()->attach($request->get("waypoints"));
          else{
            $url = "https://maps.googleapis.com/maps/api/geocode/json?key=".env("GOOGLE_API_KEY")."&region=CH&address=".urlencode($point->name);
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $url);
            if($res->getStatusCode() == 200)
            {
              $body = json_decode($res->getBody(),true);
              $point->geo = $body["results"][0];
            }
            $point->save();
            $run->waypoints()->attach($point);

          }
        }

        
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
        $seats = $run->subscriptions->map(function($sub){
          return $sub->car->nb_place;
        })->sum();
        if($seats < $run->nb_passenger)
          throw new NotAcceptableHttpException("The run cannot start because number you don't have enough seats avaiable ($seats) in cars (needed : {$run->nb_passenger} )");
        $run->started_at = Carbon::now();
        $run->status="gone";
        $run->subscriptions->map(function($sub){
          $sub->status = "gone";
        });
      //TODO: rethink where to put this event
      //notify the run has started, this will triger observers that will put every utalised car and runner on "gone" status
        event(new RunStartedEvent($run));
        return $run;

    }
    protected function terminateRun(Run $run){
      $run->ended_at = Carbon::now();
      $run->status="finished";
      $run->save();
      $run->delete();
    }
    public function stop(Request $request, Run $run)
    {
      $user = $this->user();
      if(!$user->can("end",$run))
        throw new UnauthorizedHttpException("You are not allowed to finish a run");
      
      $run->subscriptions->each(function($sub) use ($user){
        if($user->id = $sub->user_id){
          $sub->status = "finished";
          $sub->save();
          return false;//terminate the loop
        }
      });
      if($user->car("forceEnd",Run::class))
        $this->terminateRun($run);
      else{
        if($run->subscriptions->every(function($sub){
          return $sub->status == "finished";
        }))
          $this->terminateRun($run);
      }
      return $run;
    }
}
