<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lib\Models\Car;
use Lib\Models\CarType;
use Lib\Models\User;
use Lib\Models\Waypoint;

class CreateRunRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      
        return [
            "title"=>"required_without:artist|min:1",
            "artist"=>"required_without:title|min:1",
            "nb_passenger"=>"required|numeric|max:50",
            "planned_at"=>"sometimes|date",
            "waypoints"=>["required","min:2"],
            "waypoints.*"=>Rule::in(Waypoint::all()->pluck("id")->toArray()),
            "convoys"=>"sometimes|min:1",
            "convoys.*.car_type"=>["sometimes",Rule::in(CarType::all()->pluck("id")->toArray())],
            "convoys.*.car"=>["sometimes",Rule::in(Car::all()->pluck("id")->toArray())],
            "convoys.*.user"=>["required",Rule::in(User::all()->pluck("id")->toArray())]
          
        ];
    }
    public function messages()
    {
      return [
        "waypoints.in"=>"Could not find waypoints ".collect($this->get("waypoints")),
        "car_types.in"=>"Could not find car types ".collect($this->get("convoy.*.car_types")),
        "cars.in"=>"Could not find cars ".collect($this->get("convoys.*.cars")),
        "runners.in"=>"Could not find drivers ".collect($this->get("convoys.*.user"))
      ];
    }
}
