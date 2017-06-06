<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRunSubscriptionRequest extends FormRequest
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
          "user"=>"nullable|exists:users,id",
          "car"=>"nullable|sometimes|required_without:car_type|exists:cars,id",
          "car_type"=>"nullable|sometimes|required_without:car|exists:car_types,id",
        ];
    }
}
