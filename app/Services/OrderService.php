<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Shippo_Object;
use Stripe\Charge;

class OrderService
{
    public static function create(string $payment_method, Shippo_Object $courier) {
        try {
            $coupon = '';
            if ($v = Session::get('coupon')) {
                $coupon =  Coupon::valid($v)->first();

                if (!$coupon) {
                    return redirect()->route('checkout.index')->with(toastNotification('Coupon Not Valid', 'error'));
                }
            }

            DB::beginTransaction();
        
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
            ] + $times);


            DB::table('order_items')->insert(
                Cart::content()->map(fn($product) => [
                    'order_id' => $order_id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_quantity' => $product->qty,
                    'product_price' => $product->price,
                    'product_color' => $product->options->color,
                    'product_size' => $product->options->size,
                    'product_weight' => $product->weight,
                    ] + $times
                )->all()    
            );
    
            DB::table('shipments')->insert([
                'order_id' => $order_id,
                'address_id' => request('shipping_address'),
                'courier' => $courier['servicelevel']['name'] . '-' . $courier['provider'],
            ] + $times);

            // $order = Order::create([
            //     'user_id' => Auth::id(),
            //     'address_id' => request('billing_address'),
            //     'payment_method' => $payment_method,
            //     'subtotal_price' => Cart::priceTotal(),
            //     'discount_price' => Cart::discount(),
            //     'shipping_cost' => $courier['amount'],
            //     'total_price' => Cart::subtotal() + $courier['amount'],
            // ]);

            // $order_items = Cart::content()->map(fn($product) => [
            //     'product_id' => $product->id,
            //     'product_name' => $product->name,
            //     'product_quantity' => $product->qty,
            //     'product_price' => $product->price,
            //     'product_color' => $product->options->color,
            //     'product_size' => $product->options->size,
            //     'product_weight' => $product->weight,
            //     ]
            // )->all();

            // $order->orderItems()->createMany($order_items);

            // Shipment::create([
            //     'order_id' => $order->id,
            //     'address_id' => request('shipping_address'),
            //     'courier' => $courier['servicelevel']['name'] . '-' . $courier['provider'],
            // ]);

            DB::commit();

            // $coupon ? $coupon->increment('use_count', 1) : '';
            // Cart::destroy();
            // Session::forget('coupon');
            // Session::forget('checkout_cart');
            // Shipment::session_remove();

            return redirect()->route('home')->with(toastNotification('Order', 'created'));
    
        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex->getMessage();
            return redirect()->route('home')->with(toastNotification('Error, Please Try Later.', 'error'));
        }
    }
}