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
      "user"=>"nullable|exists:users",
      "car"=>"nullable|exists:cars",
      "car_type"=>"nullable|exists:car_type",
      "status"=>Rule::in([Status::getStatusForRessource("runs")])
    ];
  }
}