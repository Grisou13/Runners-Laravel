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
    $rules = [
      "car"=>"nullable|sometimes|exists:cars,id",
      "car_type" => "nullable|sometimes|exists:car_types,id",
      "user"=>["nullable","sometimes","exists:users,id"]
    ];
    if(!$this->route("run"))//if the run isn't in the request params
      $rules = array_merge($rules,["run"=>"required|exists:runs,id"]);
    return $rules;
  }
}