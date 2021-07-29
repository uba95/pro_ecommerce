<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CancelOrderService
{
    public static function create() {
        // try {
        
            DB::beginTransaction();
        
            $times = [
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $cancel_order_request_id = DB::table('cancel_order_requests')->insertGetId([
                "order_id" => request('order_id'),
            ] + $times);
    
            Session::get('cancel_order_items')->map(fn($item) => DB::table('cancel_order_items')->insert([
            'request_id' => $cancel_order_request_id,
            'order_item_id' => $item->id,
            'product_quantity' => $item->product_quantity,
            ] + $times)
            );
        
            DB::commit();
    
            Session::forget('cancel_order_items');

            return redirect()->route('cancel_orders.index')->with(toastNotification('Your Request Is Submited Successfully'));
    
        // } catch (\Exception $ex) {
        //     DB::rollBack();
        // }
    }
}
