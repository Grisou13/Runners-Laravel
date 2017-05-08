<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 15.03.2017
 * Time: 15:29
 */

namespace Api\Requests;


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
      "type"=>"sometimes|exists:car_types,name",
      "status"=>["sometimes","nullable",Rule::in(Status::getStatusForRessource("car"))],
      "between"=>"sometimes|required|size:2",
      "between.*"=>"date",
      "after"=>"sometimes|required_without:between|date"
    ];
  }
}