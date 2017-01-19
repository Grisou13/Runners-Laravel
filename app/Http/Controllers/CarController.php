<?php

namespace App\Http\Controllers;

use Session;
use App\Car;
use App\CarType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $car = Car::all();

        // load the view and pass the car list
        return view('car.index')->with('cars', $car);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('car.create')->with('car_types', CarType::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        //TODO : Validation
        // $this->validate($request, [
        //   'license_plates'   => 'required',
        //   'brand'            => 'required',
        //   'model'            => 'required',
        //   'car_types_id'     => 'required'
        // ]);

        $input = $request->except(["_token"]);

        $car = new Car($input);
        $type = CarType::findOrFail($request->input("car_types_id"));
        $car->car_types_id=$type->id;
        $car->save();

        // redirect
        Session::flash("flash_message", "Successfully created car !");
        return redirect("car");
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
    public function edit(Car $car)
    {
<<<<<<< HEAD
        $car = Car::find($id);
=======
>>>>>>> api-v1
        return view("car.edit")->with('car', $car)->with('car_types', CarType::all());
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

      $car = Car::findOrFail($id);

      /*//TODO : Validation
      $this->validate($request, [
        'license_plates'   => 'required',
        'brand'            => 'required',
        'model'            => 'required'
      ]);*/


      $type = CarType::findOrFail($request->input("car_types_id"));
      $car->car_types_id=$type->id;
      $input = $request->all();

      $car->fill($input)->save();

      // redirect
      Session::flash("flash_message", "Successfully created car !");
      return redirect("car");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        $car = Car::find($id);
        $car->delete();

        return redirect('car');
    }
}
