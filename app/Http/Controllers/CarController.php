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
        $this->validate($request, [
          'license_plates'   => 'required',
          'brand'            => 'required',
          'model'            => 'required'
        ]);

        $input = $request->all();

        Car::create($input);

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
    public function show(Car $car)
    {
        return view("car.show",compact("car"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::find($id);
        return view("car.edit")->with('car', $car);
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
      $rules = array(
          'license_plates'        => 'required',
          'brand'                 => 'required',
          'model'                 => 'required',
          'color'                 => 'required',
          'seats'                 => 'required|numeric',
          'comment'               => 'required',
          'shortname'             => 'required',
          'car_types_id'          => 'required|numeric'
      );
      $validator = Validator::make(Input::all(), $rules);
      // validation on wait
      // TODO: data validation

      if($validator->fails()){
        return Redirect::to("car/". $id ."/edit")->withErrors($validator)->withInput(Input::except('password'));
      }else{
        $car = Car::find($id);
        $car->license_plates = Input::get('license_plates');
        $car->brand = Input::get('brand');
        $car->model = Input::get('model');
        $car->color = Input::get('color');
        $car->seats = Input::get('seats');
        $car->comment = Input::get('comment');
        $car->shortname = Input::get('shortname');
        $car->car_types_id = Input::get('car_types_id');
        $car->save();

        return redirect("car");
      }
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
