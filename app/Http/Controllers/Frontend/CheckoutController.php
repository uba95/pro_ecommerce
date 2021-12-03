<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Shipment;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index(Request $request) {
        // try {

            $addresses = current_user()->addresses;

            if ($addresses->isEmpty()) {
                return view('pages.checkout.index', compact('addresses'));
            }

            if (Cart::content()->isEmpty()) {
                return redirect()->route('home')->with(toastNotification('Your Cart Is Empty', 'error'));
            }

            if (!CheckoutService::checkStockQuantitiesAreAvaliable()) {
                return redirect()->route('home')->with(toastNotification('Stock Quantities Are Not Enough For This Order', 'error'));
            }
            
            $cart_products = CheckoutService::setCheckoutCart();
            $address = CheckoutService::getAddress($addresses, $request->address_id);
            $shipment = $address ? Shipment::setAddress($address)->readyParcel($cart_products)->readyShipment() : null;
            
            if (request()->expectsJson()) {

                $html = optional($shipment)->rates 
                    ? view('pages.checkout.rates', compact('shipment'))->render()
                    : 'Sorry No Couriers To Your Address'; 
                   
                return response()->json(compact('html'));    
            }
            
            return optional($shipment)->rates
                ? view('pages.checkout.index', compact('cart_products', 'addresses', 'shipment')) 
                : redirect()->route('home')->with(toastNotification('Sorry No Couriers To Your Address', 'error'));

        // } catch (\Exception $ex) {
        //     abort(500);
        // }
    }

    public function coupon(Request $request) {

        $rate_amount = $request->rate_amount;
        CheckoutService::forgetCoupon();
        $coupon = CheckoutService::checkCoupon($request->coupon_name);

        if (!$coupon) {
            return response()->json([
                'error' => 'Coupon Not Valid.',
                'total' =>  CheckoutService::totalPrice($rate_amount),
            ]);
        }

        CheckoutService::setCoupon();
        
        return response()->json([
            'coupon' => $coupon,
            'total' =>  CheckoutService::totalPrice($rate_amount),
            'discount' => Cart::discount(),
        ]);
    }

    public function couponDelete(Request $request) {
        CheckoutService::forgetCoupon();
        return response()->json(['total' =>  CheckoutService::totalPrice($request->rate_amount)]);
    }
}
