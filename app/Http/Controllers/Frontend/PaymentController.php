<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Shipment;
use App\Services\OrderService;
use App\Services\PaypalService;
use App\Services\StripeService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Shippo_Object;
use App\Traits\CourierTrait;
class PaymentController extends Controller
{
    use CourierTrait;

    public function store() {

        if (Session::get('checkout_cart')->first() != Cart::content()->values()) {
            return redirect()->route('cart.show');
         }

        try {
            $courier = $this->courier();
            switch (request('payment_method')) {
               
                case 'stripe':
                    return StripeService::charge(Cart::subtotal() + $courier['amount'], $courier);
                    break;

                case 'paypal':
                    return PaypalService::charge(Cart::subtotal() + $courier['amount']);
                    break;
                
                case 'cash':
                    return OrderService::create('Cash On Delivery', $courier);
                    break;
                default:
                    return redirect()->route('home')->with(toastNotification('Error, Please Try Later.', 'error'));
            }
    
        } catch (\Exception $ex) {
            return redirect()->route('home')->with(toastNotification('Error, Please Try Later.', 'error'));
        }
    }

}
