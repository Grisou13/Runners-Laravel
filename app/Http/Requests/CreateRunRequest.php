<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

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
            "title"=>"required_unless:artist|min:1",
            "artist"=>"required_unless:title|min:1",
            "planned_at"=>"sometimes|date",
            "waypoints"=>"required|min:2",
            "waypoints.*"=>"exists:waypoints",
            "car_types.*"=>"sometimes|exists:car_types,id",
            "cars.*"=>"sometimes|exists:cars,id",
            "runners.*"=>"sometimes|exists.id"
//            "car_types"=>"required_unless:cars|min:1",
//            "car_types.*.id"=>"exists:car_types",
//            "cars"=>"required_unless:car_types|min:1",
//            "cars.*.id"=>"exists:cars",
//            "runners"=>"sometimes|min:1",
//            "runners.*.id"=>"exists,users"
        ];
    }
}
