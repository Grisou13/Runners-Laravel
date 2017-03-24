<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class CreateGroupScheduleRequest extends FormRequest
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
            "start_time"=>"required|date",
            "end_time"=>"required|date|after:_start_time",
        ];
    }
}
