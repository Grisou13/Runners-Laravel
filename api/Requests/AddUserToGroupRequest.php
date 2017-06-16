<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 08.05.2017
 * Time: 15:28
 */

namespace Api\Requests;


use Dingo\Api\Http\FormRequest;

class AddUserToGroupRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      "user"=>"sometimes|exists:car_types,id"
    ];
  }
}