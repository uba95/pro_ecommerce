<?php

namespace App\Services;

use App\Model\Shipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Shippo_Object;
use Stripe\Charge;

class OrderService
{
    public static function create(string $payment_method, Shippo_Object $courier , Charge $charge=null) {
        try {
        
            DB::beginTransaction();
        
            $stripe = [];
            if ($payment_method == 'Stripe') {
                $stripe = [
                    'payment_card' =>  $charge->payment_method_details->card->brand,
                    'card_last4' =>  $charge->payment_method_details->card->last4,
                ];
            }

            $times = [
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $order_id = DB::table('orders')->insertGetId([
                'user_id' => Auth::id(),
                'address_id' => request('billing_address'),
                'payment_method' => $payment_method,
                'subtotal_price' => Cart::priceTotal(),
                'discount_price' => Cart::discount(),
                'shipping_cost' => $courier['amount'],
                'total_price' => Cart::subtotal() + $courier['amount'],
            ] + $stripe + $times);
    
            Cart::content()->map(fn($product) => DB::table('order_items')->insert([
                'order_id' => $order_id,
                'product_id' => $product->id,
                'product_quantity' => $product->qty,
                'product_price' => $product->price,
                'product_color' => $product->options->color,
                'product_size' => $product->options->size,
                'product_weight' => $product->weight,
                ] + $times)
            );
    
            DB::table('shipments')->insert([
                'order_id' => $order_id,
                'address_id' => request('shipping_address'),
                'courier' => $courier['servicelevel']['name'] . ' ' . $courier['provider'],
            ] + $times);
    
            DB::commit();
    
            Cart::destroy();
            Session::forget('checkout_cart');
            Shipment::session_remove();

            return redirect()->route('home')->with(toastNotification('Order', 'added'));
    
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('home')->with(toastNotification('Error, Please Try Later.', 'error'));
        }
    }
}