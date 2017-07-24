<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

class ImagenRequest extends FormRequest
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

    public function rules(){
        return [
            'logo' => 'required|file|mimes:jpg,jpeg,gif,png|dimensions:min_width=200,min_height=200,max_width=1200,max_height=1200',
        ];
    }

    public function messages(){
        return [
            'logo.required' => 'Es necesario que envíe una imagen de logo.',
            'logo.file' => 'Debe enviar un archivo de imagen.',
            'logo.mimes' => 'Los formatos de imagen soportado son: .JPG, .GIF o PNG.',
            'logo.dimensions' => 'La imagen a subir debe ser superior a 200px de ancho y alto e inferior a 1200px.'
        ];
    }
    
    public function intersect($keys){
        return parent::intersect([
            'logo',
        ]);
    }
}