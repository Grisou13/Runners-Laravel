<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lib\Models\Car;
use Lib\Models\CarType;
use Lib\Models\User;
use Lib\Models\Waypoint;

class PublishRunRequest extends FormRequest
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
          "name"=>"sometimes|min:1",
          "nb_passenger"=>"sometimes|numeric|max:255",
          "note"=>"nullable|sometimes|min:1",
          "planned_at"=>"sometimes|date",
          "waypoints"=>"sometimes|min:2",
          "waypoints.*"=>"sometimes|min:1",
//          "subscriptions"                   =>"nullable|sometimes|required_without:runners|min:1",
//          "subscriptions.*.car_type"        =>"nullable|sometimes|required|exists:car_types,id",
//          "subscriptions.*.vehicle_category"=>"nullable|sometimes|required|exists:car_types,id",
//          "subscriptions.*.user"            =>"nullable|sometimes|required|exists:users,id",
//          "subscriptions.*.vehicle"         =>"nullable|sometimes|required|exists:cars,id",
//          "subscriptions.*.car"             =>"nullable|sometimes|required|exists:cars,id",
//          "runners"                   =>"nullable|sometimes|required_without:subscriptions|min:1",
//          "runners.*.car_type"        =>"nullable|sometimes|required|exists:car_types,id",
//          "runners.*.vehicle_category"=>"nullable|sometimes|required|exists:car_types,id",
//          "runners.*.user"            =>"nullable|sometimes|required|exists:users,id",
//          "runners.*.vehicle"         =>"nullable|sometimes|required|exists:cars,id",
//          "runners.*.car"             =>"nullable|sometimes|required|exists:cars,id",
            //"waypoints.*"=>Rule::in(Waypoint::all()->pluck("id")->toArray()),
        ];
    }
    public function messages()
    {
      return [
        "waypoints.in"=>"Could not find waypoints ".collect($this->get("waypoints")),
//        "car_types.in"=>"Could not find car types ".collect($this->get("convoy.*.car_types")),
//        "cars.in"=>"Could not find cars ".collect($this->get("convoys.*.cars")),
//        "runners.in"=>"Could not find drivers ".collect($this->get("convoys.*.user"))
      ];
    }
}
