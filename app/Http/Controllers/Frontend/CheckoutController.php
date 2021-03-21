<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\Model\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Coupon;
use App\Model\Shipment;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index() {
        try {
            
            $cart_products = Cart::content();
            $cart_coll = new Collection();
            $cart_session = $cart_coll->push(Cart::content()->values());
            Session::put('checkout_cart', $cart_session);

            $customer = User::with('addresses')->find(Auth::id());
            $addresses = $customer->addresses;
            $address = request('address_id') ? $addresses->where('id', request('address_id'))->first() : $addresses->first();
            $shipment = $address && count($cart_products) > 0 ? 
            $this->createShippingProcess($cart_products, $address) : null;
            
            if (request()->expectsJson()) {

                $html = $shipment ? view('pages.checkout.rates', compact('shipment'))->render(): 'Not Found';    
                return response()->json(compact('html'));    
            }
            
            return view('pages.checkout.index', compact('cart_products', 'addresses', 'shipment')) ;

        } catch (\Exception $ex) {
            abort(500, 'Error, Please Try Later.');
        }
    }
    public function coupon() {

        try {

            $coupon = Coupon::where('coupon_name', request('coupon_name'))->first();

            $rate_amount = request('rate_amount');
            $total = Cart::priceTotal() + $rate_amount;
            Cart::setGlobalDiscount(0);

            if (!$coupon) {
                return response()->json(['error' => 'Coupon Not Found.'] + compact('total'));
            }

            // $rate_amount = (new Shipment())->retrieveRate(request('rate_object_id'))->amount;
            if ($coupon && $rate_amount) {

                Cart::setGlobalDiscount(10);
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

    private function createShippingProcess($cart_products, $address)
    {
        return Shipment::setPickupAddress()->setDeliveryAddress($address)->readyParcel($cart_products)->readyShipment();
    }
}
