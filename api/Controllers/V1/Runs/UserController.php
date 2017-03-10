<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1\Runs;

use Api\Controllers\BaseController;
use Lib\Models\Run;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Http\Request;
use Api\Responses\Transformers\RunTransformer;

class UserController extends BaseController
{
    public function index(Request $request)
    {
      return $this->response()->collection(Run::all(), new RunTransformer);
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
    public function store(Request $request)
    {
        $run = new Run;
        // TODO: create run if runners are provided for car_type, and/or cars
        // For now this is not taken car of

        /**
        * Waypoint is an array containing a waypoint id, and the order
        * [
        *   ["id"=>WaypointId,"order"=>integer]
        * ]
        * @var $waypoints Array
        */
        $waypoints = $request->get("waypoints");
        foreach($waypoints as $point)
        {
          $run->waypoints()->attach(Waypoint::find($point["id"]),["order"=>$point["order"]]);
        }
        if($request->has("runners"))
        {
          /**
          * Same as waypoints except doesn't have order
          * [
          *  ["id"=>integer]
          * ]
          * @var $runners Array
          */
          $runners = $request->get("runners");
          foreach($runners as $runner){
            $run->users()->attach(User::find($runner["id"]));
          }
        }
        if($request->has("car_types"))
        {
          /**
          * Same as waypoints except doesn't have order
          * [
          *  ["id"=>integer]
          * ]
          * @var $types Array
          */
          $types = $request->get("car_types");
          foreach($types as $type){
            $run->car_types()->attach(User::find($type["id"]));
          }
        }
        if($request->has("cars"))
        {
          /**
          * Same as waypoints except doesn't have order
          * [
          *  ["id"=>integer]
          * ]
          * @var $cars Array
          */
          $cars = $request->get("cars");
          foreach($cars as $car){
            $run->cars()->attach(User::find($car["id"]));
          }
        }
        $run->fill($request->all());
        $run->save();
        return $this->response()->created();
    }
    public function delete(Run $run)
    {
        return $run->delete();
    }
}
