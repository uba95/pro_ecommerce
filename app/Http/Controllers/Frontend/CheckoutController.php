<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index() {
        // try {

            if (!Cart::content()->every(fn($v) => $v->model->product_quantity > $v->qty)) {
                return redirect()->route('home')->with(toastNotification('Stock Quantities Is Not Enough For This Order', 'error'));
            }
            
            $cart_products = Cart::content();
            $cart_coll = new Collection();
            $cart_session = $cart_coll->push(Cart::content()->values());
            Session::put('checkout_cart', $cart_session);

            $customer = User::with('addresses')->find(Auth::id());
            $addresses = $customer->addresses;
            $address = request('address_id') ? $addresses->where('id', request('address_id'))->first() : $addresses->first();
            $shipment = $address && count($cart_products) ? 
            Shipment::setAddress($address)->readyParcel($cart_products)->readyShipment() : null;
            
            if (request()->expectsJson()) {

                $html = !$shipment || optional($shipment)->rates 
                ? view('pages.checkout.rates', compact('shipment'))->render()
                : 'Sorry No Couries To Your Address'; 
                   
                return response()->json(compact('html'));    
            }
            
            return !$shipment || optional($shipment)->rates ? 
            view('pages.checkout.index', compact('cart_products', 'addresses', 'shipment')) :
            redirect()->route('home')->with(toastNotification('Sorry No Couries To Your Address', 'error'));

        // } catch (\Exception $ex) {
        //     abort(500);
        // }
    }
    public function coupon() {

        try {

            $coupon = Coupon::valid(request('coupon_name'))->first();

            $rate_amount = request('rate_amount');
            $total = Cart::priceTotal() + $rate_amount;
            Cart::setGlobalDiscount(0);
            Session::forget('coupon');
            Session::save();

            if (!$coupon) {
                return response()->json(['error' => 'Coupon Not Valid.'] + compact('total'));
            }
            if ($coupon && $rate_amount) {
                Session::put('coupon', $coupon->coupon_name);
                Cart::setGlobalDiscount($coupon->discount);
                $discount =  Cart::discount();
                $total = Cart::subtotal() + $rate_amount;
            }

            $route = route('checkout.coupon.destroy');
             
            return response()->json(compact('discount', 'total','coupon', 'route'));
           
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error, Please Try Later.']);
        }
    }

    public function couponDelete() {

        try {  
            Cart::setGlobalDiscount(0);    
            return response()->json(['total' =>  Cart::priceTotal() + request('rate_amount')]);
           
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error, Please Try Later.']);
        }
    }
}
