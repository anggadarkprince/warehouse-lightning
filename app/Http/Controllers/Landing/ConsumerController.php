<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ConsumerController extends Controller
{
    /**
     * Show retail customer.
     *
     * @param Request $request
     * @return View
     */
    public function retail(Request $request)
    {
        return view('landing.consumer.retail');
    }

    /**
     * Show healthcare customer.
     *
     * @param Request $request
     * @return View
     */
    public function healthcare(Request $request)
    {
        return view('landing.consumer.healthcare');
    }

    /**
     * Show industrial and chemical customer.
     *
     * @param Request $request
     * @return View
     */
    public function industrial(Request $request)
    {
        return view('landing.consumer.industrial');
    }

    /**
     * Show power generation customer.
     *
     * @param Request $request
     * @return View
     */
    public function power(Request $request)
    {
        return view('landing.consumer.power');
    }

    /**
     * Show food and beverage customer.
     *
     * @param Request $request
     * @return View
     */
    public function food(Request $request)
    {
        return view('landing.consumer.food');
    }

    /**
     * Show oil and gas customer.
     *
     * @param Request $request
     * @return View
     */
    public function oil(Request $request)
    {
        return view('landing.consumer.oil');
    }
}
