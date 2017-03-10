<?php
/**
* User: Joel.DE-SOUSA
*/
namespace App\Http\Controllers;

use Lib\Models\Comment;
use App\Http\Requests\CreateCommentRequest;
use Lib\Models\User;
use Session;
use Lib\Models\Car;
use Lib\Models\CarType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Http\Requests\CreateCarRequest;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',["only"=>["store","create","update","edit"]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $cars = Car::all();

        // load the view and pass the car list
        return view('car.index')->with('cars', $cars);
    }

    /**
     * Show the form for creating a new resource.
     * @author Thomas.RICCI
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('car.create')->with('car_types', CarType::all())->with("car",new Car());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCarRequest $request){
        //$request->flash();
        $input = $request->except(["_token"]);

        $car = new Car($input);
        $type = CarType::findOrFail($request->input("type"));
        $car->car_type()->associate($type);
        $car->save();

        // redirect
        return redirect()->route("cars.index")->with("message","Car created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
      return view("car.edit")->with('car', $car)->with('car_types', CarType::all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        return view("car.edit")->with('car', $car)->with('car_types', CarType::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
      
      $this->api()->be(auth()->user())->with($request->except("_token"))->update();
      //$car = Car::findOrFail($id);

      /*//TODO : Validation
      $this->validate($request, [
        'license_plates'   => 'required',
        'brand'            => 'required',
        'model'            => 'required'
      ]);*/


      $input = $request->all();

      $car->fill($input)->save();
      if($request->has("car_type"))
      {
        $type = CarType::findOrFail($request->input("car_type"));

        $car->car_type()->associate($type);
      }
      $car->save();
      // redirect
      return redirect()->back()->with("message","Car updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        // delete
        $car->delete();
        return redirect()->route("cars.index")->with("message","Car deleted successfully");
    }


    public function addComment(Car $car, CreateCommentRequest $request)
    {

        $comment = new Comment;
        $comment->fill($request->except("_token"));
        $comment->commentable()->associate($car);
        if($request->has("user"))
            $user = User::find($request->get("user"));
        else
            $user = $request->user();

        if($user == null)
        {
            redirect()->back()->withErrors(["user"=>"Must provide a username or log in"]);
        }
        $comment->user()->associate($user);
        $comment->save();

        return redirect()->back();
    }
}
