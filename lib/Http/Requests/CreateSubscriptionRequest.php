<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 10.03.2017
 * Time: 15:25
 */

namespace Lib\Http\Requests;


use Dingo\Api\Http\FormRequest;

class CreateSubscriptionRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      "car"=>"nullable|exists:cars,id",
      "car_type" => "required_unless:car|exists:car_types,id",
      "user"=>["nullable","exists:users,id"]
    ];
  }
}