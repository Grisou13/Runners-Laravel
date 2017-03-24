<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 10.03.2017
 * Time: 14:00
 */

namespace App\Http\Requests;


use Dingo\Api\Http\FormRequest;

class UserUnjoinRequest extends FormRequest
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
      "id"=>"exists:users"
    ];
  }
}
