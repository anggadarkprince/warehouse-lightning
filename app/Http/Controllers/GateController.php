<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\DeliveryOrder;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GateController extends Controller
{
    public function index(Request $request)
    {
        $code = $request->get('code');

        if (!empty($code)) {
            $parseCode = explode('-', $code);
            if (count($parseCode) > 0) {
                switch ($parseCode[0]) {
                    case 'DI':
                    case 'DO':
                        return $this->scanDeliveryOrder($code);
                        break;
                    default:
                        return redirect()->route('gate.index')->with([
                            'status' => "failed",
                            "message" => "Code number {$code} is not recognized"
                        ]);
                }
            }
        }

        return view('gate.index');
    }

    /**
     * Show delivery order data.
     *
     * @param $code
     * @return View|RedirectResponse
     */
    private function scanDeliveryOrder($code)
    {
        $deliveryOrder = DeliveryOrder::where('delivery_number', $code)->first();
        if (empty($deliveryOrder)) {
            return redirect()->route('gate.index')->with([
                'status' => "failed",
                "message" => "Delivery order not found"
            ]);
        }

        $users = User::all();

        return view('gate.delivery-order', compact('deliveryOrder', 'users'));
    }
}
