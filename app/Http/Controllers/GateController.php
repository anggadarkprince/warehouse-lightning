<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
     * @return View
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

        session()->flash("status", "success");
        session()->flash("message", "Delivery order {$deliveryOrder->delivery_number} found");
        return view('gate.delivery-order', compact('deliveryOrder'));
    }
}
