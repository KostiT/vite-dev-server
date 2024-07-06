<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestrictedController
{
    public function __invoke(Request $request)
    {
        return inertia("Restricted", [
            "ipAddress" => $request->ip(),
        ]);
    }
}
