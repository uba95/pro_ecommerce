<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Order;
use App\Model\CancelOrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CancelOrderRequestController extends Controller
{
    public function index() {
     
        return view('pages.orders.cancel_requests', ['cancel_order_requests' => CancelOrderRequest::with('order')->get()]);
    }

    public function store(Request $request) {
        try {
            
            $order = Order::find($request->order_id);
            // $this->authorize('create', [CancelOrderRequest::class, $order]);
            $this->authorize('view', $order);

            if (in_array($order->status, ['pending', 'paid']) || !$order->cancelOrderRequest) {
                CancelOrderRequest::create(['order_id' => $request->order_id]);
                return redirect()->route('cancel_orders.index')->with(toastNotification('Your Request Is Submited Successfully'));
            }
        } catch (\Throwable $th) {
            abort(404);
        }
    }
}
