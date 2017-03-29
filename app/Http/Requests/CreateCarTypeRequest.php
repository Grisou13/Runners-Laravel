<?php
/**
*User: Joel.DE-SOUSA
*/
namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class CreateCarTypeRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name'=>"required|min:2",
          "description"=>"sometimes|required|max:255"
        ];
    }
}
