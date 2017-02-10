<?php
/**
*User: Joel.DE-SOUSA
*/
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
          'plate_number'   => 'required|unique:cars,plate_number',
          'brand'            => 'required',
          'model'            => 'required',
          'type'     => 'required',
          'nb_place'=>"required|numeric"
        ];
    }
}
