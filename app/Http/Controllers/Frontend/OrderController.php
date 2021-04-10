<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Order;
use App\Model\OrderItem;
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

        return $request->expectsJson() 
        ? response()->json(OrderItem::withReturnableQuantities($orderItems))
        : view('pages.orders.show', compact('order', 'orderItems')); 
    }
}
