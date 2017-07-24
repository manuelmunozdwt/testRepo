<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Http\Requests\Traits\CuponRequestTrait;

class CuponRequest extends Request
{
    use  CuponRequestTrait;
}
