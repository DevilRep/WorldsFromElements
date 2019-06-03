<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class User extends Controller
{
    public function show(Request $request)
    {
        return response()->json($request->user());
    }
}
