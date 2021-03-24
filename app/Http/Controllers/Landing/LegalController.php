<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Show dynamic legal page.
     *
     * @param Request $request
     * @param $page
     * @return View
     */
    public function index(Request $request, $page)
    {
        if (view()->exists('legals.' . $page)) {
            $page = 'index';
        }
        return view("legals/{$page}");
    }
}
