<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 23.03.2017
 * Time: 13:54
 */

namespace Api\Requests;


use App\Helpers\Status;
use Dingo\Api\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListRunRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      "status"=>["nullable","sometimes",Rule::in(Status::getStatusForRessource("run"))]
    ];
  }
}