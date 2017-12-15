<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRunRequest;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\EditRunRequest;
use App\Http\Requests\PublishRunRequest;
use App\Http\Requests\RunPdfRequest;
use Auth;
use Lib\Models\RunSubscription;
use PDF;
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
    public function __construct(){
      $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view("run.index");
    }

  /**
   * Shows the big screen "display" mode of runs
   * @return View
   */
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
   * @param EditRunRequest|Request $request
   * @param Run $run
   * @return View
   * @internal param int $id
   */
    public function edit(EditRunRequest $request,Run $run)
    {
      return view("run.edit")->with("run",$run)->with("car_types",CarType::all())->with("waypoints", Waypoint::all())->with("cars",Car::all())->with("users",User::all());
    }

  /**
   * Publishes a run through the api
   * @param PublishRunRequest $request
   * @param Run $run
   * @return \Illuminate\Http\RedirectResponse
   */
    public function publish(PublishRunRequest $request, Run $run)
    {

      $run_data = $request->except(["subscriptions","_token","_method"]);
      $subs = $this->prepareSubsForApi($request);
      $data = array_merge($run_data, ["subscriptions"=>$subs]);
      $run = $this->api->be(Auth::user())->post("/api/runs/{$run->id}/publish",$data);
      return redirect()->route("runs.edit",compact("run"));
    }

  /**
   * Store a newly created resource in storage.
   *
   * @param CreateRunRequest|Request $request
   * @return \Illuminate\Http\Response
   */
    public function store(CreateRunRequest $request)
    {
        try{
          $run_data = $request->except(["subscriptions","_token"]);
          $subs = $this->prepareSubsForApi($request);
          $data = array_merge($run_data, ["subscriptions"=>$subs]);
          $run = $this->api->be(Auth::user())->post("/runs",$data);
        }
        catch (ValidationException $e){
          redirect()->back()->withErrors($e)->withInput($request->all());
        }
        return redirect()->route("runs.edit",compact("run"));
    }

  /**
   * Update run through the api.
   *
   * @param CreateRunRequest|Request $request
   * @param Run $run
   * @return \Illuminate\Http\Response
   * @internal param int $id
   */
    public function update(CreateRunRequest $request, Run $run)
    {
        $run_data = $request->except(["subscriptions","_token"]);
        $subs = $this->prepareSubsForApi($request);
        $data = array_merge($run_data, ["subscriptions"=>$subs]);
        $run = $this->api->be(Auth::user())->patch("/runs/{$run->id}",$data);
        return redirect()->back();
    }
    protected function prepareSubsForApi(Request $request)
    {
      $subs = [];
      foreach($request->get("subscriptions",[]) as $sub) {
        $d = [
          "car_type" => $sub["car_type"] == "" ? null : $sub["car_type"],
          "car" => $sub["car"] == "" ? null : $sub["car"],
          "user" => $sub["user"] == "" ? null : $sub["user"],
        ];
        if(array_key_exists("id", $sub) && !empty($sub["id"]))
          $d["id"] = $sub["id"];
        $subs[] = $d;
      }
      return $subs;
    }

  /**
   * Deletes a run through the api.
   *
   * @param Run $run
   * @return \Illuminate\Http\Response
   * @internal param int $id
   */
    public function destroy(Run $run)
    {
        $this->api->be(Auth::user())->delete("/runs/{$run->id}");
        return redirect()->route("runs.index");
    }

  /**
   * Adds a comment to a run
   * @param CreateCommentRequest $request
   * @param Run $run
   * @return \Illuminate\Http\RedirectResponse
   */
    public function addComment(CreateCommentRequest $request, Run $run){
      $this->api->be(Auth::user())->post("/runs/{$run->id}/comments",$request->except(["_token"]));
      return redirect()->back();
    }

  /**
   * Generates a pdf or runs from a blade view
   * @param RunPdfRequest $request
   * @return mixed
   */
    public function pdf(RunPdfRequest $request){

      if($request->has("runs"))
        $runs = Run::whereIn("id",$request->get("runs",[]))->with(["waypoints","runners","runners.user","runners.car","runners.car_type"])->withCount(["runners"])->get();
      else
        $runs = Run::with(["waypoints","runners","runners.user","runners.car","runners.car_type"])->withCount(["runners"])->get();
      $pdf = PDF::loadView('run.pdf', compact("runs"), [], [
        'orientation'=>"L",
        "format"=>"A3"
      ]);
      return $pdf->stream('document.pdf');
    }

  /**
   * Force start of a run
   * @param Request $request
   * @param Run $run
   * @return \Illuminate\Http\RedirectResponse
   */
    public function start(Request $request, Run $run)
    {
      $this->api()->be(auth()->user())->post("/runs/{$run->id}/start");
      return redirect()->back();
    }

  /**
   * Force stop of a run
   * @param Request $request
   * @param Run $run
   * @return \Illuminate\Http\RedirectResponse
   */
    public function stop(Request $request, Run $run)
    {
      $this->api()->be(auth()->user())->post("/runs/{$run->id}/stop");
      return redirect()->back();
    }
}
