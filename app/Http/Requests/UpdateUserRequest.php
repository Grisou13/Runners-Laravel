<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
          'name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users,email,'.$this->user->id,
          'phone' => 'required|max:255',
          'sex' => 'required|max:255',
          'stat' => 'required|max:255',
          'accesstoken' => 'required|max:255',
          'password' => 'required|min:6|confirmed'
        ];
    }
}
