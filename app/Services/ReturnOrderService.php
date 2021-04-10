<?php

namespace App\Services;

use App\Model\ReturnOrderRequest;
use App\Model\Shipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Shippo_Object;
use Stripe\Charge;

class ReturnOrderService
{

    public static function create(string $payment_method, Shippo_Object $courier) {
        try {
        
            DB::beginTransaction();
        
            $times = [
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $return_order_request_id = DB::table('return_order_requests')->insertGetId([
                'billing_address_id' => request('billing_address'),
                'shipping_address_id' => request('shipping_address'),
                'payment_method' => $payment_method,
                'shipping_cost' => $courier['amount'],
                'courier' => $courier['servicelevel']['name'] . '-' . $courier['provider'],
                "order_id" => request('order_id'),
                "reason" => request('reason'),
                "details" => request('details'),
                ] + $times);
    
                Session::get('return_order_items')->map(fn($order_item) => DB::table('return_order_items')->insert([
                'request_id' => $return_order_request_id,
                'order_item_id' => $order_item->id,
                'product_quantity' => $order_item->product_quantity,
                ] + $times)
            );
        
            DB::commit();
    
            Session::forget('return_order_items');
            Shipment::session_remove();

            return redirect()->route('return_orders.index')->with(toastNotification('Your Request Is Submited Successfully'));
    
        } catch (\Exception $ex) {
            DB::rollBack();
        }
    }
}
