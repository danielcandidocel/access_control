<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class Controller
{
    public function __construct() {
        Gate::authorize('permission', strtolower(Route::currentRouteName()));
    }
}
