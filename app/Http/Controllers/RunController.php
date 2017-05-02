<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRunRequest;
use Auth;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Contracts\View\View;
use Lib\Models\Car;
use Lib\Models\CarType;
use Lib\Models\Run;
use Dingo\Api\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Lib\Models\User;
use Lib\Models\Waypoint;

class RunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        //$runs = Run::withCount("waypoints")->with(["waypoints","users","subscriptions","subscriptions.car","subscriptions.user","subscriptions.car_type"])->orderBy("status")->orderBy("planned_at")->actif()->get();
        return view("run.index");
    }
    public function display()
    {
      if(!Auth::check())
        Auth::onceUsingId(1);//force login
      return view("run.display");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view("run.create")->with("run",new Run)->with("car_types",CarType::all())->with("waypoints", Waypoint::all())->with("cars",Car::all())->with("users",User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRunRequest $request)
    {
        $run_data = $request->except(["subscriptions","waypoints"]);
        
        $run = $this->api->be(Auth::user())->post("/runs",$run_data);
        foreach($request->get("subscriptions",[]) as $sub){
          $this->api->be(Auth::user())->post("/runs/{$run->id}/runners",$sub);
        }
        foreach($request->get("waypoints",[]) as $point){
          $this->api->be(Auth::user())->post("/runs/{$run->id}/waypoints",$point);
        }
        return redirect()->route("runs.index");
    }

  /**
   * Display the specified resource.
   *
   * @param Run $run
   * @return View
   * @internal param int $id
   */
    public function show(Run $run)
    {
        return view("run.show",compact("run"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(Request $request,Run $run)
    {
      return view("run.create")->with("run",$run)->with("car_types",CarType::all())->with("waypoints", Waypoint::all())->with("cars",Car::all())->with("users",User::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Run $run)
    {
        $run_data = $request->except(["subscriptions","waypoints"]);
    
        $run = $this->api->be(Auth::user())->put("/runs",$run_data);
        $this->api->be(Auth::user())->delete("/runs/{$run->id}/runners");
        $this->api->be(Auth::user())->delete("/runs/{$run->id}/waypoints");
        foreach($request->get("subscriptions",[]) as $sub){
          $this->api->be(Auth::user())->post("/runs/{$run->id}/runners",$sub);
        }
        foreach($request->get("waypoints",[]) as $point){
          $this->api->be(Auth::user())->post("/runs/{$run->id}/waypoints",$point);
        }
        return redirect()->route("runs.index");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Run $run)
    {
        $this->api->delete(app(UrlGenerator::class)->version("v1")->route("runs.destroy",$run));
        return redirect()->back();
    }
}
