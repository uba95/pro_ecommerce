<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Enums\CancelOrderStatus;
use App\Model\CancelOrderRequest;
use App\Http\Controllers\Controller;
use Spatie\Enum\Laravel\Rules\EnumRule;

class CancelOrderRequestController extends Controller
{
    public function index(Request $request) {

        $cancel_order_requests =  
        CancelOrderRequest::with('order:id,user_id,payment_method,total_price,status,created_at', 'order.user:id,name')
        ->get();

        $cancel_order_requests = $request->status 
        ?  $cancel_order_requests->filter(fn($r) => $r->status == $request->status) 
        : $cancel_order_requests;
        
        return view('admin.orders.cancel_order_requests', compact('cancel_order_requests'));    
    }

    public function update(CancelOrderRequest  $cancelOrder, Request $request) {

        $validated = $request->validate(['status' => new EnumRule(CancelOrderStatus::class)]);
        $cancelOrder->update(['status' => $validated['status']]);
        if ($request->status == 'approved') {
            $cancelOrder->order->update(['status' =>  OrderStatus::canceled()->getIndex()]);
            return redirect()->route('admin.cancel_orders.index')->with(toastNotification('Request Is Approved And Order Is Canceld'));
        }
        
        return redirect()->route('admin.cancel_orders.index')->with(toastNotification('Request', 'updated'));
    }
}
