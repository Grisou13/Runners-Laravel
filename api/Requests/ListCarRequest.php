<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 15.03.2017
 * Time: 15:29
 */

namespace App\Http\Requests;


use App\Helpers\Status;
use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListCarRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      "type"=>"exists:car_types,name",
      "status"=>["sometimes",Rule::in(Status::getStatusForRessource("car"))]
    ];
  }
}