<?php

namespace App\Http\Controllers\Admin\Order;

use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Services\AjaxDatatablesService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Mail;
use Spatie\Enum\Laravel\Rules\EnumRule;

class OrderController extends Controller
{
    public function __construct() {
        $this->middleware('can:view orders',    ['only' => ['index', 'show']]);
        $this->middleware('can:edit orders',    ['only' => ['update']]);
    }

    public function index(Request $request) {
        $orders = $request->status && in_array($request->status, OrderStatus::getValues())
        ? Order::with('user:id,name', 'shipment:order_id,courier')->whereEnum('status', $request->status)
        : Order::with('user:id,name', 'shipment:order_id,courier');
        return request()->expectsJson() ? AjaxDatatablesService::orders($orders) : view('admin.orders.index');
    }

    public function show(Order $order) {
     
        $orderItems = $order->orderItems()->notCanceled()->with('product')->get();
        return view('admin.orders.show', compact('order', 'orderItems')); 
    }

    public function update(Order $order, Request $request) {

        $validated = $request->validate(['status' => new EnumRule(OrderStatus::class)]);

        if ($order->isCancelPending() || $order->isReturnPending()) {
            $message = $order->isCancelPending() ? 'Cancel' : 'Return';
            return back()->with(toastNotification("There Is $message Order Requset You Must Resolve It First", 'error'));
        }
        
        if ($request->status == 'shipped') {
            if (!$order->itemsAreAvailable()) {
                return back()->with(toastNotification("Stock Quantities Is Not Enough For This Order", 'error'));
            } 
            $order->decrementStock();
            $order->shipment->update(['started_at' => now()]);  
        }

        $request->status == 'delivered' ? $order->shipment->update(['delivered_at' => now()]) : '';
        $order->update(['status' => $validated['status']]);

        Mail::to($order->user->email)->send(new OrderMail($order));

        return redirect()->route('admin.orders.show', $order->id)->with(toastNotification('Order', 'updated'));
    }

    public function showInvoice(Order $order) {
        return $order->status == 'canceled'
        ? redirect()->route('admin.orders.show', $order->id)->with(toastNotification('Error, Order Is Canceled', 'error')) 
        : OrderService::generateInvoice($order);
    }
}
