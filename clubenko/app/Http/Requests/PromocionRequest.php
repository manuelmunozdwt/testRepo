<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Http\Requests\Traits\PromocionRequestTrait;

class PromocionRequest extends Request
{
    use  PromocionRequestTrait {
        rules as public traitrules;
    }

    public function rules()
    {
        $rules = [
            'precio_descuento' => 'required',
        ];

        return array_merge($rules,$this->traitrules());
    }

}
