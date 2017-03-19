<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 10.03.2017
 * Time: 11:40
 */

namespace App\Http\Requests;


use App\Helpers\Status;
use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRunSubscription extends FormRequest
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
  public function rules()
  {
    return [
      "user"=>"exists:users,id",
      "car"=>"required_without:car_type|exists:cars,id",
      "car_type"=>"required_without:car|exists:car_types,id",
      //"status"=>Rule::in([Status::getStatusForRessource("runs")])
    ];
  }
}