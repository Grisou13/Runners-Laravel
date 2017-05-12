<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRunRequest;
use App\Http\Requests\CreateCommentRequest;
use Auth;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Lib\Models\Car;
use Lib\Models\CarType;
use Lib\Models\Run;
use Dingo\Api\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Lib\Models\User;
use Lib\Models\Waypoint;
use Lib\Models\Comment;

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
        $run_data = $request->except(["subscriptions","_token"]);
        try{
          $subs = [];
          foreach($request->get("subscriptions",[]) as $sub){
            $data = [
              "car_type"=>$sub["car_type"] == "-1" ? null : $sub["car_type"],
              "car"=>$sub["car"] == "-1" ? null : $sub["car"],
              "user"=>$sub["user"] == "-1" ? null : $sub["user"],
            ];
            $subs[] = $data;
          }
          $data = array_merge($run_data,["subscriptions"=>$subs]);
          //dd($data);
          $run = $this->api->be(Auth::user())->post("/runs",$data);
        }
        catch (ValidationException $e){
          redirect()->back()->withErrors($e)->withInput($request->all());
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
        //dd($request->all());
        $run_data = $request->except(["subscriptions","_token"]);
        $subs = [];
        foreach($request->get("subscriptions",[]) as $sub) {
          $d = [
            "car_type" => $sub["car_type"] == "-1" ? null : $sub["car_type"],
            "car" => $sub["car"] == "-1" ? null : $sub["car"],
            "user" => $sub["user"] == "-1" ? null : $sub["user"],
          ];
          if(array_key_exists("id", $sub) && !empty($sub["id"]))
            $d["id"] = $sub["id"];
          $subs[] = $d;
        }
        $data = array_merge($run_data, ["subscriptions"=>$subs]);
        $run = $this->api->be(Auth::user())->patch("/runs/{$run->id}",$data);

//        return redirect()->route("runs.index");
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

    public function addComment(CreateCommentRequest $request, Run $run){
      $comment = new Comment;
      $comment->fill($request->except("user"));
      $comment->commentable()->associate($run);
      if($request->has("user"))
          $user = User::find($request->get("user"));
      else
          $user = $request->user();
      $comment->user()->associate($user);
      $comment->save();
      return redirect()->back();
    }
}
