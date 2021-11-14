<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Address;
use App\Models\Shipment;
use App\Models\OrderItem;
use App\Traits\CourierTrait;
use Illuminate\Http\Request;
use App\Models\ReturnOrderItem;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Models\ReturnOrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnOrderFormRequest;
use App\Services\ReturnOrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReturnOrderRequestController extends Controller
{
    use CourierTrait;
    
    public function index() {
        return view('pages.orders.return.index', [
            'return_order_requests' => ReturnOrderRequest::with('order')
                ->whereHas('order', fn($q) => $q->where('user_id', current_user()->id))->latest()->get()]);
    }

    public function show(ReturnOrderRequest $returnOrder) {
        
        $this->authorize('view', $returnOrder->order);
        $returnOrderItems = $returnOrder->returnOrderItems->load('orderItem');
        return view('pages.orders.return.show', compact('returnOrder', 'returnOrderItems'));
    }

    public function create(Request $request) {

        if ($request->expectsJson()) {
            return $this->shipment($request);
        }

        return view('pages.orders.return.create', [
            'orders' => Order::with('orderItems','user:id')
            ->returnable()
            ->where('user_id', current_user()->id)
            ->latest('id')
            ->get(['id','user_id']),
            'reasons' => ReturnOrderRequest::REASONS
        ]);
    }

    public function store(ReturnOrderFormRequest $request) {
        try {
            $courier = $this->courier();
            switch ($request->payment_method) {
               
                case 'stripe':
                    return StripeService::charge($courier['amount'], $courier, true);
                    break;

                case 'paypal':
                    return PaypalService::charge($courier['amount'], true);
                    break;
                
                case 'cash':
                    return ReturnOrderService::create(Order::PAYMENT_METHODS['cash'], $courier, $request->all());
                    break;
                default:
                    return redirect()->route('home')->with(toastNotification('No Payment Method', 'error'));
            }
    
        } catch (\Exception $ex) {
            return redirect()->route('home')->with(toastNotification('Error, Please Try Later.', 'error'));
        }
    }

    private function shipment($request) {

        $order  =  Order::with('orderItems')->returnable()->where('id', $request->order_id)->firstOrFail();
        $orginalOrderItems  =  $order->orderItems;

        if (!$request->order_items || array_diff($request->order_items, $orginalOrderItems->pluck('id')->toArray())) {
            return response()->json(['html' => 'Error, Check Your Order Items']);
        }

        $this->authorize('view', $order);
        $orderItems = $orginalOrderItems->whereIn('id', $request->order_items);
        $return_order_items = ReturnOrderService::returnableQuantitiesRequset($orderItems, $request->quantity);

        if (!$return_order_items) {
            return response()->json(['html' => 'Error, Check Your Order Items Quantities']);
        }

        Session::put('return_order_items', $return_order_items);

        $address =  Address::where(['id' => $request->address_id, 'user_id' => current_user()->id])->first();
        $shipment = $address ? Shipment::setAddress($address, true)->readyParcel($return_order_items, false)->readyShipment() : null;
        
        $html = optional($shipment)->rates 
        ? view('pages.checkout.rates', compact('shipment'))->render()
        : 'Sorry No Couriers To Your Address'; 
            
        return response()->json(compact('html'));    
    }

    public function destroy(ReturnOrderRequest $returnOrder) {

        $this->authorize('view', $returnOrder->order);

        if ($returnOrder->status != 'pending') {
            return redirect()->route('return_orders.index')->with(toastNotification('Return Order Request Can\'t Be Deleted', 'error'));
        }

        $returnOrder->delete();
        return redirect()->route('return_orders.index')->with(toastNotification('Return Order Request', 'deleted'));
    }

}
