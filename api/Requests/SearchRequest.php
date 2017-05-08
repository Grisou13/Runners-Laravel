<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 29.03.2017
 * Time: 09:03
 */

namespace Api\Requests;


use Dingo\Api\Http\FormRequest;

class SearchRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    return [
      "q"=>"required|min:1"
    ];
  }
}