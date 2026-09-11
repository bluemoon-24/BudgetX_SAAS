<?php

namespace App\Http\Controllers;

use App\Traits\ApiFilterable;
use App\Traits\ApiResponser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use ApiFilterable, ApiResponser, AuthorizesRequests;
}
