<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
          'firstname' => 'required|max:255',
          'lastname' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'sometimes|required|min:6|confirmed'
        ];
    }
}
