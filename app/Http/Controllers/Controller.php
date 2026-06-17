<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Traits\ApiFilterable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use ApiResponser, ApiFilterable, AuthorizesRequests;
}
