<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\CancelOrderRequest;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\CancelOrderItem;
use App\Models\OrderItem;
use App\Models\Shipment;
use App\Services\CancelOrderService;
use App\Traits\CourierTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Shippo_Object;

class CancelOrderRequestController extends Controller
{
    use CourierTrait;

    public function index() {
        return view('pages.orders.cancel.index', [
            'cancel_order_requests' => CancelOrderRequest::with('order')
                ->whereHas('order', fn($q) => $q->where('user_id', current_user()->id))->latest()->get()
        ]);
    }

    public function show(CancelOrderRequest $cancelOrder) {
        
        $this->authorize('view', $cancelOrder->order);
        $cancelOrderItems = $cancelOrder->cancelOrderItems->load('orderItem');
        return view('pages.orders.cancel.show', compact('cancelOrder', 'cancelOrderItems'));
    }

    public function create(Request $request) {

        if ($request->expectsJson()) {
            return $this->shipment($request);
        }

        return view('pages.orders.cancel.create', [
            'orders' => Order::with('orderItems','user:id')
            ->cancelable()
            ->where('user_id', current_user()->id)
            ->latest('id')
            ->get(['id','user_id']),
        ]);
    }

    public function store(Request $request) {
        
        if ($request->cancelAll) {
            $order  =  Order::with('orderItems')->cancelable()->where('id', $request->order_id)->firstOrFail();
            $this->authorize('view', $order);
            Session::put('cancel_order_items',  $order->orderItems);
            return CancelOrderService::create(new Shippo_Object, $request->only('order_id'));
        }

        return CancelOrderService::create($this->courier(), $request->all());
    }

    private function shipment($request) {
     
        $order  =  Order::with('orderItems')->cancelable()->where('id', $request->order_id)->firstOrFail();
        $orginalOrderItems  =  $order->orderItems;

        if (!$request->order_items || array_diff($request->order_items, $orginalOrderItems->pluck('id')->toArray())) {
            return response()->json(['html' => 'Error, Check Your Order Items']);
        }

        $this->authorize('view', $order);
        $orderItems = $orginalOrderItems->whereIn('id', $request->order_items);
        $cancel_order_items = CancelOrderService::cancelableQuantitiesRequset($orderItems, $request->quantity);

        if (!$cancel_order_items) {
            return response()->json(['html' => 'Error, Check Your Order Items Quantities']);
        }

        Session::put('cancel_order_items', $cancel_order_items);
        $remainingItems = CancelOrderService::remainingQuantities($orginalOrderItems, $cancel_order_items);
        
        if ($remainingItems->isEmpty()) {
            $html = 'All Order Is Canceling';
            $remainingItems = collect();
            $itemsAfter = view('pages.orders.cancel.items-after', compact('remainingItems'))->render();
            return response()->json(compact('html', 'itemsAfter'));    
        }

        $address =  Address::where(['id' => $request->address_id, 'user_id' => current_user()->id])->first();
        $shipment = $address ? Shipment::setAddress($address, true)->readyParcel($remainingItems, false)->readyShipment() : null;

        $html = optional($shipment)->rates
        ? view('pages.checkout.rates', compact('shipment'))->render()
        : 'Sorry No Couriers To Your Address'; 

        $itemsAfter = view('pages.orders.cancel.items-after', [
            'order'     =>  $order, 
            'shipment'  => $shipment,
            'subtotal'  => $subtotal = $remainingItems->sum->totalPrice,
            'discount'  => discountPrice($subtotal, optional($order->coupon)->discount),
            'remainingItems'  => $remainingItems,
            ]
        )->render();

        return response()->json(compact('html', 'itemsAfter'));    
    }

    public function destroy(CancelOrderRequest $cancelOrder) {

        $this->authorize('view', $cancelOrder->order);

        if ($cancelOrder->status != 'pending') {
            return redirect()->route('cancel_orders.index')->with(toastNotification('Cancel Order Request Can\'t Be Deleted', 'error'));
        }

        $cancelOrder->delete();
        return redirect()->route('cancel_orders.index')->with(toastNotification('Cancel Order Request', 'deleted'));
    }
}
