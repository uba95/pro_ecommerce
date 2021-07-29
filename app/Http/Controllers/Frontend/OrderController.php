<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        return view('pages.orders.index', [
          'orders' => Order::with('user:id,name', 'shipment:order_id,courier')->where('user_id', Auth::id())->latest()->get()
        ]);
    }

    public function show(Order $order, Request $request)
    {
        $orderItems = OrderItem::with('product')->where('order_id', $order->id)->get();
        $this->authorize('view', $order);

        if ($request->expectsJson()) {
            if ($request->cancel) {
                return response()->json(OrderItem::withCancelableQuantities($orderItems));
            }
            if ($request->return) {
                return response()->json(OrderItem::withReturnableQuantities($orderItems));
            }
        }
        return view('pages.orders.show', compact('order', 'orderItems')); 
    }
}
