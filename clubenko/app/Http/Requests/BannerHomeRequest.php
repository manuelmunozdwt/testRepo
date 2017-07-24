<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BannerHomeRequest extends Request
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
            'imagen'    => ''
        ];
    }


    public function messages(){
        return [
            'imagen.required'   => 'El banner es requerido',
            'imagen.dimensions' => 'Las dimensiones del banner tienen que ser 1056px por 100px',
        ];
    }
}