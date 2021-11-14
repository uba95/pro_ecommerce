<?php

namespace App\Services;

use App\Models\ReturnOrderRequest;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Shippo_Object;
use Stripe\Charge;

class ReturnOrderService
{

    public static function create(string $payment_method, Shippo_Object $courier, $data = [], $items = []) {
        try {
        
            DB::beginTransaction();
        
            $times = [
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $return_order_request_id = DB::table('return_order_requests')->insertGetId([
                'billing_address_id' => $data['billing_address'],
                'shipping_address_id' => $data['shipping_address'],
                'payment_method' => $payment_method,
                'shipping_cost' => $courier['amount'],
                'courier' => $courier['servicelevel']['name'] . '-' . $courier['provider'],
                "order_id" => $data['order_id'],
                "reason" => $data['reason'],
                "details" => $data['details'],
            ] + $times);

            $items = $items ?: Session::get('return_order_items');

            DB::table('return_order_items')->insert(
                $items->map(fn($item) => [
                    'request_id' => $return_order_request_id,
                    'order_item_id' => $item->id,
                    'product_quantity' => $item->product_quantity,
                    ] + $times
                )->all()    
            );

            DB::commit();
    
            Session::forget('return_order_items');
            Shipment::session_remove();

            return redirect()->route('return_orders.index')->with(toastNotification('Your Request Is Submited Successfully'));
    
        } catch (\Exception $ex) {
            DB::rollBack();
        }
    }

    public static function returnableQuantities($orderItems) {

        return $orderItems->clone()->each(fn($v) => $v->product_quantity -=  $v->returnOrderItems()
            ->whereDoesntHave('returnOrderRequest', fn($q) => $q->whereEnum('status', ['pending', 'rejected']))
            ->sum('product_quantity')
        )->filter(fn($v) => $v->product_quantity > 0)->values();
    }

    public static function returnableQuantitiesRequset($orderItems, $quantity) {

        $returnable_items = self::returnableQuantities($orderItems);
        return $returnable_items->isNotEmpty() && $returnable_items->every(fn($v, $k) => $v->product_quantity >= $quantity[$k]) 
        ? $returnable_items->each(fn($v, $k) => $v->product_quantity = $quantity[$k])
        : null;
    }
}
