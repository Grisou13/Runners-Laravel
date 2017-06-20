<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;
use Lib\Models\User;

class EditRunRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      /** @var User */
      $user = $this->user();
      if(!$user)
        $user = app('Dingo\Api\Auth\Auth')->user();
      
      return $user && $user->hasPermissionTo("edit run");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
