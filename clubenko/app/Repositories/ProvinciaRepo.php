<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Provincias;

class ProvinciaRepo
{
	public function get_todas()
    {
        return Provincias::get();
    }

    public function get_provincia($id)
    {
        return Provincias::where('id', $id)
            ->first();
    }

}