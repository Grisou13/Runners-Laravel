<?php

namespace App\Http\Controllers\Run;
use App\Car;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserJoinRequest;
use App\Run;
use App\RunDriver;
use App\User;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function join(UserJoinRequest $request, Run $run, Car $car)
    {
      $sub = RunDriver::find(["car"=>$car,"run"=>$run]);
      $sub->user()->associate($request->get("id"))->save();
      //$run->whereHas("cars",$car)->pivot->user()->associate($request->get("id"))->save();
    }
    public function unjoin(UserJoinRequest $request, Run $run, Car $car)
    {
      $sub = RunDriver::find(["car"=>$car,"run"=>$run]);
      $run->whereHas("cars",$car)->first()->pivot->user()->detach($request->get("id"))->save();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //when adding a car, check the pivot table and remove the car_type
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
