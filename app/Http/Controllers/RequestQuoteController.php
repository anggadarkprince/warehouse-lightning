<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestQuoteController extends Controller
{
    public function index()
    {
        return view('landing.quote');
    }
}
