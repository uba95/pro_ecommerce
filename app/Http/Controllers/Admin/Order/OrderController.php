<?php

namespace App\Http\Controllers\Admin\Order;

use App\Model\Order;
use App\Model\OrderItem;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Enum\Laravel\Rules\EnumRule;

class OrderController extends Controller
{
    public function index(Request $request) {
        
        $orders = Order::with('user:id,name', 'shipment:order_id,courier')->get();
        $orders = $request->status ?  $orders->filter(fn($order) => $order->status == $request->status) : $orders;
        return view('admin.orders.index', compact('orders'));    
    }

    public function show(Order $order) {
     
        $orderItems = OrderItem::with('product')->where('order_id', $order->id)->get();
        return view('admin.orders.show', compact('order', 'orderItems')); 
    }

    public function update(Order $order, Request $request) {

        if ($order->isCancelPending() || $order->isReturnPending()) {
            $message = $order->isCancelPending() ? 'Cancel' : 'Return';
            return redirect()->back()->with(toastNotification("There Is $message Order Requset You Must Resolve It First", 'error'));
        }

        $request->status == 'shipped' ? $order->shipment->update(['started_at' => now()]) : '';
        $request->status == 'delivered' ? $order->shipment->update(['delivered_at' => now()]) : '';
        $validated = $request->validate(['status' => new EnumRule(OrderStatus::class)]);
        $order->update(['status' => $validated['status']]);

        return redirect()->route('admin.orders.show', $order->id)->with(toastNotification('Order', 'updated'));
    }
}
