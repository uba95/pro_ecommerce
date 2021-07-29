<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\CancelOrderRequest;
use App\Http\Controllers\Controller;
use App\Models\CancelOrderItem;
use App\Models\OrderItem;
use App\Services\CancelOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CancelOrderRequestController extends Controller
{
    public function index() {
        return view('pages.orders.cancel.index', ['cancel_order_requests' => CancelOrderRequest::with('order')->get()]);
    }

    public function show(CancelOrderRequest $cancelOrder) {
        $cancelOrderItems = $cancelOrder->cancelOrderItems->load('orderItem');
        return view('pages.orders.cancel.show', compact('cancelOrder', 'cancelOrderItems'));
    }

    public function create(Request $request) {

        return view('pages.orders.cancel.create', [
            'orders' => Order::where('user_id', Auth::id())
            ->whereEnum('status', ['pending', 'paid', 'partiallyCanceled'])
            ->with('orderItems','user:id')
            ->latest('id')
            ->get(['id','user_id']),
        ]);
    }

    public function store(Request $request) {

        $orderItems = OrderItem::with('order:id,user_id')->find($request->order_items);

        if ($orderItems->isEmpty()) {
            return back()->with(toastNotification('Error, Check Your Order Items', 'error'));
        }
        
        $orderItems->each(fn($orderItem) => $this->authorize('view', $orderItem->order));

        $products = OrderItem::cancelableQuantitiesRequset($orderItems, $request->quantity);

        if (!$products) {
            return back()->with(toastNotification('Error, Check Your Order Items Quantities', 'error'));
        }

        Session::put('cancel_order_items', $products);

        return CancelOrderService::create();
    }
}
