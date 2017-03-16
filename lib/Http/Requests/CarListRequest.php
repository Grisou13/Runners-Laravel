<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 15.03.2017
 * Time: 15:29
 */

namespace Lib\Http\Requests;


use Dingo\Api\Http\FormRequest;

class CarListRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      "type"=>"exists:car_types,name"
    ];
  }
}