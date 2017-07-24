<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Http\Requests\Traits\UserRequestTrait;

class UserRequest extends Request
{
    use  UserRequestTrait;
}
