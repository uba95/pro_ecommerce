<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\ReturnOrderService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show($order_id, Request $request)
    {
        $order  =  Order::with(['orderItems' => fn($q) => $q->notCanceled()->with('product')])
            ->where('id', $order_id)
            ->where('user_id', current_user()->id);
        
        if ($request->expectsJson()) {
            if ($request->cancel) {
                $order  = $order->cancelable()->firstOrFail();
                return response()->json($order->orderItems);
            }
            if ($request->return) {
                $order  = $order->returnable()->firstOrFail();
                return response()->json(ReturnOrderService::returnableQuantities($order->orderItems));
            }
        }

        $order  = $order->firstOrFail();
        return view('pages.orders.show', compact('order')); 
    }

    public function showInvoice(Order $order) {

        $this->authorize('view', $order);

        return $order->status == 'canceled'
        ? redirect()->route('orders.show', $order->id)->with(toastNotification('Error, Order Is Canceled', 'error')) 
        : OrderService::generateInvoice($order);
    }

}
