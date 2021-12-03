<?php

namespace App\Services;

use App\Mail\CancelOrderMail;
use App\Models\CancelOrderRequest;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Shippo_Object;

class CancelOrderService
{
    public static function create(Shippo_Object $courier, $data = [], $items = []) {
        try {
        
            DB::beginTransaction();
            
            $times = [
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $cancel_order_request = CancelOrderRequest::create([
                "order_id" => $data['order_id'],
                'billing_address_id' => $data['billing_address'] ?? null,
                'shipping_address_id' => $data['shipping_address'] ?? null,
                'shipping_cost' => $courier['amount'],
                'courier' => $courier['servicelevel'] ? ($courier['servicelevel']['name']  . '-' . $courier['provider']) : null,
                'status' => 0,
            ] + $times);

            $items = $items ?: Session::get('cancel_order_items');

            DB::table('cancel_order_items')->insert(
                $items->map(fn($item) => [
                    'request_id' => $cancel_order_request->id,
                    'order_item_id' => $item->id,
                    'product_quantity' => $item->product_quantity,
                    ] + $times
                )->all()    
            );
        
            DB::commit();

            Session::forget('cancel_order_items');
            Shipment::session_remove();

            Mail::to(current_user()->email)->send(new CancelOrderMail($cancel_order_request));
            
            return redirect()->route('cancel_orders.index')->with(toastNotification('Your Request Is Submited Successfully'));
    
        } catch (\Exception $ex) {
            DB::rollBack();
        }
    }

    public static function withCancelableQuantities($orderItems) {
        // check order Item quantity and pending requests quantities;

        return $orderItems->filter(fn($v) => $v->product_quantity > 0)->values();
    }

    public static function cancelableQuantitiesRequset($orderItems, $quantity) {
        // check the request quantities and return cancel order items;

        return $orderItems->isNotEmpty() && $orderItems->every(fn($v, $k) => $v->product_quantity >= $quantity[$k]) 
        ? $orderItems->clone()->each(fn($v, $k) => $v->product_quantity = (int) $quantity[$k])
        : null;
    }

    public static function remainingQuantities($orderItems, $cancel_order_items) {
        return $orderItems->clone()->each(fn ($v) => $v->product_quantity -= optional($cancel_order_items
            ->firstWhere('id', $v->id))->product_quantity
        )->filter(fn($v) => $v->product_quantity > 0)->values();
    }
}
