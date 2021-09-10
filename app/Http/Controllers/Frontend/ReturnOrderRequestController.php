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
        return view('pages.orders.return.index', ['return_order_requests' => ReturnOrderRequest::with('order')->get()]);
    }

    public function show(ReturnOrderRequest $returnOrder) {
        $returnOrderItems = $returnOrder->returnOrderItems->load('orderItem');
        return view('pages.orders.return.show', compact('returnOrder', 'returnOrderItems'));
    }

    public function create(Request $request) {

        if ($request->expectsJson()) {
            return $this->shipment($request);
        }

        return view('pages.orders.return.create', [
            'orders' => Order::where('user_id', Auth::id())
            ->whereEnum('status', ['delivered', 'returning', 'partiallyReturned'])
            ->with('orderItems','user:id','user.addresses.country:id,name')
            ->latest('id')
            ->get(['id','user_id']),
        ]);
    }

    public function store(ReturnOrderFormRequest $request) {
        // dd($request->all());
        try {
            $courier = $this->courier();
            switch (request('payment_method')) {
               
                case 'stripe':
                    return StripeService::charge($courier['amount'], $courier, true);
                    break;

                case 'paypal':
                    return PaypalService::charge($courier['amount'], true);
                    break;
                
                case 'cash':
                    return ReturnOrderService::create('Cash On Delivery', $courier);
                    break;
                default:
                    return redirect()->route('home')->with(toastNotification('No Payment Method', 'error'));
            }
    
        } catch (\Exception $ex) {
            return redirect()->route('home')->with(toastNotification('Error, Please Try Later.', 'error'));
        }
    }

    private function shipment($request) {
     
        $orderItems = OrderItem::with('order:id,user_id')->find($request->order_items);
        if ($orderItems->isEmpty()) {
            return response()->json(['html' => 'Error, Check Your Order Items']);
        }

        // $orderItems->each(fn($orderItem) => $this->authorize('create', [ReturnOrderRequest::class, $orderItem]));
        $orderItems->each(fn($orderItem) => $this->authorize('view', $orderItem->order));

        $products = OrderItem::returnableQuantitiesRequset($orderItems, $request->quantity);
        if (!$products) {
            return response()->json(['html' => 'Error, Check Your Order Items Quantities']);
        }

        Session::put('return_order_items', $products);

        $address =  Address::where(['id' => $request->address_id, 'user_id' => Auth::id()])->first();
        $shipment = Shipment::setAddress($address, true)->readyParcel($products, false)->readyShipment();
        
        $html = !$shipment || optional($shipment)->rates 
        ? view('pages.checkout.rates', compact('shipment'))->render()
        : 'Sorry No Couriers To Your Address'; 
            
        return response()->json(compact('html'));    
    }
}
