<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutService {

  public static $coupon;

  public static function checkoutCartIsChanged() {
    return Session::get('checkout_cart') != Cart::content()->values();
  }

  public static function checkStockQuantitiesAreAvaliable() {
    return Cart::content()->every(fn($v) => $v->model->product_quantity > $v->qty);
  }

  public static function setCheckoutCart() {
    Session::put('checkout_cart', collect(Cart::content()->values()));
    return Cart::content();
  }

  public static function getAddress($addresses, $address_id = null) {
    return $addresses->when($address_id, fn($v) => $v->where('id', $address_id))->first();
  }

  public static function checkCoupon(string $coupon_name) {
    $coupon = Coupon::valid($coupon_name)->first();
    return self::$coupon = $coupon;
  }

  public static function setCoupon() {
    Session::put('coupon', self::$coupon->coupon_name);
    Cart::setGlobalDiscount(self::$coupon->discount);
  }

  public static function totalPrice($rate_amount) {
    return $rate_amount + (self::$coupon ? Cart::subtotal() : Cart::priceTotal());
  }
  
  public static function forgetCoupon() {
    Cart::setGlobalDiscount(0);   
    Session::forget('coupon');
    Session::save(); 
  } 
}