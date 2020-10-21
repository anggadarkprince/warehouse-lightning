<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Show account information form.
     *
     * @param Request $request
     * @return View
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('edit-account', User::class);

        return view('account.index', ['user' => $request->user()]);
    }
}
