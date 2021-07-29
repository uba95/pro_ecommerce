<?php

namespace App\Models;

use App\Enums\CancelOrderStatus;
use App\Traits\DateScopesTrait;
use Spatie\Enum\Laravel\HasEnums;
use Illuminate\Database\Eloquent\Model;

class CancelOrderRequest extends Model
{
    use HasEnums;
    use DateScopesTrait;

    protected $guarded = [];
    protected $casts = ['status' => 'int'];
    protected $enums = ['status' => CancelOrderStatus::class];

    public function order() {
     
        return $this->belongsTo(Order::class);
    }

    public function cancelOrderItems() {
     
        return $this->hasMany(CancelOrderItem::class, 'request_id');
    }

    public function decrementOrderItems() {

        $this->cancelOrderItems->map(fn($v) => $v->orderItem->decrement('product_quantity', $v->product_quantity));
    }

    public function scopeTotalCancel($q) {
        
        return $q->selectRaw("SUM(order_items.product_price * cancel_order_items.product_quantity) as Total")
        ->join('cancel_order_items', 'cancel_order_requests.id', 'cancel_order_items.request_id')
        ->join('order_items', 'cancel_order_items.order_item_id', 'order_items.id')
        ->whereNotIn('cancel_order_requests.status', [
            CancelOrderStatus::pending()->getIndex(), 
            CancelOrderStatus::rejected()->getIndex()
        ]);
    }
}
