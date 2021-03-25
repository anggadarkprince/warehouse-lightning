<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Show warehousing service.
     *
     * @param Request $request
     * @return View
     */
    public function warehousing(Request $request)
    {
        return view('landing.services.warehousing');
    }

    /**
     * Show air freight service.
     *
     * @param Request $request
     * @return View
     */
    public function airFreight(Request $request)
    {
        return view('landing.services.air-freight');
    }

    /**
     * Show ocean service.
     *
     * @param Request $request
     * @return View
     */
    public function oceanFreight(Request $request)
    {
        return view('landing.services.ocean-freight');
    }

    /**
     * Show road service.
     *
     * @param Request $request
     * @return View
     */
    public function roadFreight(Request $request)
    {
        return view('landing.services.road-freight');
    }

    /**
     * Show supply chain service.
     *
     * @param Request $request
     * @return View
     */
    public function supplyChain(Request $request)
    {
        return view('landing.services.supply-chain');
    }

    /**
     * Show packaging service.
     *
     * @param Request $request
     * @return View
     */
    public function packaging(Request $request)
    {
        return view('landing.services.packaging');
    }
}
