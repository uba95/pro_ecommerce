<?php

namespace App\Http\Controllers\Admin\Order;

use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Enums\CancelOrderStatus;
use App\Models\CancelOrderRequest;
use App\Http\Controllers\Controller;
use App\Mail\CancelOrderMail;
use App\Models\CancelOrderItem;
use App\Services\AjaxDatatablesService;
use Illuminate\Support\Facades\Mail;
use Spatie\Enum\Laravel\Rules\EnumRule;

class CancelOrderRequestController extends Controller
{
    public function __construct() {
        $this->middleware('can:view orders',    ['only' => ['index', 'show']]);
        $this->middleware('can:edit orders',    ['only' => ['update']]);
    }

    public function index(Request $request) {

        $cancelnOrders = CancelOrderRequest::with(
            'order:id,user_id,status,created_at',
            'order.user:id,name'
        )->select('cancel_order_requests.*');

        $cancel_order_requests = $request->status && in_array($request->status, CancelOrderStatus::getValues())
        ? $cancelnOrders->whereEnum('status', $request->status)
        : $cancelnOrders;

        return  request()->expectsJson() 
                ? AjaxDatatablesService::cancel_order_requests($cancel_order_requests) 
                : view('admin.orders.cancel_order_requests');
    }

    public function show(CancelOrderRequest $cancelOrder) {
        $cancelOrderItems = $cancelOrder->cancelOrderItems->load('orderItem');
        return view('admin.orders.cancel_order_show', compact('cancelOrder', 'cancelOrderItems')); 
    }

    public function update(CancelOrderRequest  $cancelOrder, Request $request) {

        $validated = $request->validate(['status' => new EnumRule(CancelOrderStatus::class)]);
        $cancelOrder->update(['status' => $validated['status']]);
        $order = $cancelOrder->order;
        $msg = toastNotification('Request', 'updated');

        if ($request->status == 'approved') {

            $cancelOrder->decrementOrderItems();

            $data = [
                'subtotal_price' => $subtotalPrice = $order->orderItems->sum->totalPrice,
                'discount' => $discount = (float) discountPrice($subtotalPrice, optional($order->coupon)->discount),
                'shipping_cost' => $shipping = $cancelOrder->shipping_cost,
                'total_price' => $subtotalPrice - $discount + $shipping,    
            ];

            if ($order->areAllItemsCanceled()) {
                $data['status'] = OrderStatus::canceled()->getIndex();
            }
            
            $order->update($data);
            $msg = toastNotification('Request Is Approved And Order Items Are Canceled');
        }

        Mail::to($cancelOrder->order->user->email)->send(new CancelOrderMail($cancelOrder));
        
        return redirect()->route('admin.cancel_orders.index')->with($msg);
    }
}
