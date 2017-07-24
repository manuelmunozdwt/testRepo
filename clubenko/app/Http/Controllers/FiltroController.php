<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\FiltroRepo;

class FiltroController extends Controller
{

	public function __construct(FiltroRepo $filtroRepo)
    {
        $this->filtroRepo = $filtroRepo;
    }
    public function get_filtro($filtro_id = null){
    	if (is_null($filtro_id)) {
    		return false;
    	}

    	return $this->filtroRepo->datos_filtro($filtro_id);
    }
}
