<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * @param $page
     * @return View
     */
    public function index($page)
    {
        if (view()->exists('legals.' . $page)) {
            $page = 'index';
        }
        return view("legals/{$page}");
    }
}
