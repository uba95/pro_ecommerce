<?php

namespace App\Models;

use App\Enums\CancelOrderStatus;
use App\Traits\DateScopesTrait;
use Illuminate\Database\Eloquent\Model;

class CancelOrderItem extends Model
{
    use DateScopesTrait;

    protected $guarded = [];

    public function cancelOrderRequest() {
     
        return $this->belongsTo(CancelOrderRequest::class, 'request_id');
    }

    public function orderItem() {
     
        return $this->belongsTo(OrderItem::class);
    }

    public function getTotalPriceAttribute() {
        return calculateTotalPrice($this->orderItem->product_price, $this->product_quantity);
    }

    public function scopeTotalCancel($q) {
        
        return $q->selectRaw("order_items.product_id, order_items.product_name,
        SUM(cancel_order_items.product_quantity) AS tq, 
        SUM(order_items.product_price * cancel_order_items.product_quantity) as total
        ")
        ->join('cancel_order_requests', 'cancel_order_requests.id', 'cancel_order_items.request_id')
        ->join('order_items', 'cancel_order_items.order_item_id', 'order_items.id')
        ->whereNotIn('cancel_order_requests.status', [
            CancelOrderStatus::pending()->getIndex(), 
            CancelOrderStatus::rejected()->getIndex()
        ])->groupBy('order_items.product_id');
    }
}
