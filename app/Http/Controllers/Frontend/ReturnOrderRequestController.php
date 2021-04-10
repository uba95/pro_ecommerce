<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Order;
use App\Model\Address;
use App\Model\Shipment;
use App\Model\OrderItem;
use App\Traits\CourierTrait;
use Illuminate\Http\Request;
use App\Model\ReturnOrderItem;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Model\ReturnOrderRequest;
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

    public function show(ReturnOrderRequest $returnOrderRequest) {
        $returnOrderItems = ReturnOrderItem::with('orderItem')->where('request_id', $returnOrderRequest->id)->get();
        return view('pages.orders.return.show', compact('returnOrderRequest', 'returnOrderItems'));
    }

    public function create(Request $request) {

        if ($request->expectsJson()) {
            return $this->shipment($request);
        }

        return view('pages.orders.return.create', [
            'orders' => Order::where('user_id', Auth::id())
            ->whereEnum('status', ['shipped', 'delivered', 'returning', 'returned'])
            ->with('orderItems','user:id','user.addresses.country:id,name')
            ->latest('id')
            ->get(['id','user_id']),
        ]);
    }

    public function store(ReturnOrderFormRequest $request) {
        
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
        if (!$orderItems) {
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
        : 'Sorry No Couries To Your Address'; 
            
        return response()->json(compact('html'));    
    }
}
