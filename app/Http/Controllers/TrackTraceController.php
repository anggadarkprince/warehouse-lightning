<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrackTraceController extends Controller
{
    public function index()
    {
        return view('landing.tracker');
    }
}
