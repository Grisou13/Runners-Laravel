<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1;


use App\Car;
use Api\Controllers\BaseController;
use App\Http\Requests\CreateCarRequest;
use Illuminate\Http\Request;

class CarController extends BaseController
{
    public function index()
    {
        return Car::all();
    }
    public function show(Car $car)
    {
        return $car;
    }

    public function update(Request $request, Car $car)
    {
        $car->update($request->all());
        return $this->response()->accepted(route("api.cars.show",$car->id));
    }
    public function store(CreateCarRequest $request)
    {
        $car = new Car;
        $car->fill($request->all());
        $car->save();
        return $this->response()->created(route("api.cars.show",$car->id));
    }
    public function delete(Car $car)
    {
        return $car->delete();
    }
}
