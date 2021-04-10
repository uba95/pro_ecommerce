<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\OrderStatus;
use App\Enums\ReturnOrderStatus;
use Illuminate\Http\Request;
use App\Model\ReturnOrderItem;
use App\Model\CancelOrderRequest;
use App\Model\ReturnOrderRequest;
use App\Http\Controllers\Controller;
use Spatie\Enum\Laravel\Rules\EnumRule;

class ReturnOrderRequestController extends Controller
{
    public function index(Request $request) {
        
        $return_order_requests =  
        ReturnOrderRequest::with('order:id,user_id,payment_method,total_price,status,created_at', 'order.user:id,name')
        ->get();

        $return_order_requests = $request->status 
        ?  $return_order_requests->filter(fn($r) => $r->status == $request->status) 
        : $return_order_requests;
        
        return view('admin.orders.return_order_requests', compact('return_order_requests'));    
    }

    public function show($id) {
     
        $returnOrderRequest = ReturnOrderRequest::find($id);

        $returnOrderItems = ReturnOrderItem::with('orderItem')->where('request_id', $returnOrderRequest->id)->get();

        return $returnOrderRequest ? view('admin.orders.return_order_show', compact('returnOrderRequest', 'returnOrderItems')) 
        : redirect()->back()->with(toastNotification('Request', 'not_found'));
    }

    public function update(ReturnOrderRequest $returnOrder, Request $request) {

        $request->status == 'shipped' ? $returnOrder->update(['shipping_started_at' => now()]) : '';
        $request->status == 'returned' ? $returnOrder->update(['shipping_returned_at' => now()]) : '';
        $validated = $request->validate(['status' => new EnumRule(ReturnOrderStatus::class)]);
        $returnOrder->update(['status' => $validated['status']]);
        
        if ($request->status == 'approved') {
            $returnOrder->order->update(['status' => OrderStatus::returning()->getIndex()]);
            return redirect()->route('admin.return_orders.index')->with(toastNotification('Request Is Approved And Order Is In Returning Process'));
        }

        if ($request->status == 'refunded') {
            $returnOrder->order->update(['status' => OrderStatus::returned()->getIndex()]);
            return redirect()->route('admin.return_orders.index')->with(toastNotification('Request Is Refunded And Order Is Rerurned'));
        }
        
        return redirect()->route('admin.return_orders.index')->with(toastNotification('Request', 'updated'));
    }
}