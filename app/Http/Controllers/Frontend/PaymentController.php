<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Shipment;
use App\Services\OrderService;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Shippo_Object;
use App\Traits\CourierTrait;
class PaymentController extends Controller
{
    use CourierTrait;

    public function store(PaymentRequest $request) {

        if (Session::get('checkout_cart')->first() != Cart::content()->values()) {
            return redirect()->route('cart.show')->with(toastNotification('Please Refresh Your Cart', 'error'));
        }

        try {
            $courier = $this->courier();
            switch ($request->payment_method) {
               
                case 'stripe':
                    return StripeService::charge(Cart::subtotal() + $courier['amount'], $courier);
                    break;

                case 'paypal':
                    return PaypalService::charge(Cart::subtotal() + $courier['amount']);
                    break;
                
                case 'cash':
                    return OrderService::create(Order::PAYMENT_METHODS['cash'], $courier, $request->only('billing_address', 'shipping_address'));
                    break;
                default:
                    return redirect()->route('home')->with(toastNotification('Payment Method Not Exist', 'error'));
            }
    
        } catch (\Exception $ex) {
            return redirect()->route('home')->with(toastNotification('Error, Please Try Later.', 'error'));
        }
    }

}
