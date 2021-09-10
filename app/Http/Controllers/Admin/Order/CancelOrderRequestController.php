<?php

namespace App\Http\Controllers\Admin\Order;

use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Enums\CancelOrderStatus;
use App\Models\CancelOrderRequest;
use App\Http\Controllers\Controller;
use App\Models\CancelOrderItem;
use Spatie\Enum\Laravel\Rules\EnumRule;

class CancelOrderRequestController extends Controller
{
    public function __construct() {
        $this->middleware('can:view orders',    ['only' => ['index', 'show']]);
        $this->middleware('can:edit orders',    ['only' => ['update']]);
    }

    public function index(Request $request) {

        $cancelnOrders = CancelOrderRequest::with(
            'order:id,user_id,payment_method,total_price,status,created_at',
            'order.user:id,name'
        );

        $cancel_order_requests = $request->status && in_array($request->status, CancelOrderStatus::getValues())
        ? $cancelnOrders->whereEnum('status', $request->status)->get()
        : $cancelnOrders->get();

        return view('admin.orders.cancel_order_requests', compact('cancel_order_requests'));    
    }

    public function show(CancelOrderRequest $cancelOrder) {
        $cancelOrderItems = $cancelOrder->cancelOrderItems->load('orderItem');
        return view('admin.orders.cancel_order_show', compact('cancelOrder', 'cancelOrderItems')); 
    }

    public function update(CancelOrderRequest  $cancelOrder, Request $request) {

        $validated = $request->validate(['status' => new EnumRule(CancelOrderStatus::class)]);
        $cancelOrder->update(['status' => $validated['status']]);

        if ($request->status == 'approved') {
            
            $cancelOrder->decrementOrderItems();

            if ($cancelOrder->order->areAllItemsCanceled()) {
                $cancelOrder->order->update(['status' =>   OrderStatus::canceled()->getIndex()]);
            }

            return redirect()->route('admin.cancel_orders.index')->with(toastNotification('Request Is Approved And Order Items Are Canceled'));
        }
        
        return redirect()->route('admin.cancel_orders.index')->with(toastNotification('Request', 'updated'));
    }
}
