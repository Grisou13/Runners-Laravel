<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            "waypoints"=>"required|min:2",
            "car_types"=>"required_unless:cars|min:1",
            "car_types.*.id"=>"exists:car_types",
            "cars"=>"required_unless:car_types|min:1",
            "cars.*.id"=>"exists:cars",
            "runners"=>"sometimes|min:1"
        ];
    }
}
