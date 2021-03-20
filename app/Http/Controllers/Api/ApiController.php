<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function version()
    {
        return response()->json([
            'name' => config('app.name'),
            'version' => 'v1.0'
        ]);
    }
}
