<?php
/**
*User: Joel.DE-SOUSA
*/
namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class CreateCarRequest extends FormRequest
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
          'plate_number'  => 'nullable|sometimes|unique:cars,plate_number',
          'brand'         => 'nullable|sometimes',
          'model'         => 'nullable|sometimes',
          'name'          => 'nullable|sometimes|min:1',
          'car_type'      => 'required',
          'nb_place'      => "nullable|numeric"
        ];
    }
}
