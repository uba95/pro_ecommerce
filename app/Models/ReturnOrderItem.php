<?php

namespace App\Models;

use App\Enums\ReturnOrderStatus;
use App\Traits\DateScopesTrait;
use Illuminate\Database\Eloquent\Model;

class ReturnOrderItem extends Model
{    
    use DateScopesTrait;

    protected $guarded = [];

    public function returnOrderRequest() {
     
        return $this->belongsTo(ReturnOrderRequest::class, 'request_id');
    }

    public function orderItem() {
     
        return $this->belongsTo(OrderItem::class);
    }
    
    public function getTotalPriceAttribute() {
        return calculateTotalPrice($this->orderItem->product_price, $this->product_quantity);
    }

    public function scopeTotalReturn($q) {
        
        return $q->selectRaw("order_items.product_id, order_items.product_name,
        SUM(return_order_items.product_quantity) AS tq,
        SUM(order_items.product_price * return_order_items.product_quantity) as total
        ")
        ->join('return_order_requests', 'return_order_requests.id', 'return_order_items.request_id')
        ->join('order_items', 'return_order_items.order_item_id', 'order_items.id')
        ->whereNotIn('return_order_requests.status', [
            ReturnOrderStatus::pending()->getIndex(), 
            ReturnOrderStatus::rejected()->getIndex()
        ])->groupBy('order_items.product_id');
    }
}
