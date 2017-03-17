<?php

namespace App\Http\Controllers;

use Auth;
use Lib\Models\Run;
use Dingo\Api\Routing\UrlGenerator;
use Illuminate\Http\Request;

class RunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $runs = Run::withCount("waypoints")->with(["waypoints","runners"])->orderBy("planned_at")->get();
        return view("run.index",compact("runs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("run.create")->with("run",new Run);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $run = $this->api->post(app(UrlGenerator::class)->version("v1")->route("runs.store"))->be(Auth::user())->with($request->except(["_token"]));
        return redirect()->back();
    }
  
  /**
   * Display the specified resource.
   *
   * @param Run $run
   * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Run $run)
    {
        return view("run.edit")->with($run);
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
        $this->toApiRoute("patch","runs.update",$run,$request);
        //$this->api->patch(app(UrlGenerator::class)->version("v1")->route("runs.update",$run))->with($request->except(["_token"]));
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
