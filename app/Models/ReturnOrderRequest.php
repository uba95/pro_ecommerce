<?php

namespace App\Models;

use App\Models\Order;
use App\Enums\ReturnOrderStatus;
use App\Traits\DateScopesTrait;
use Spatie\Enum\Laravel\HasEnums;
use Illuminate\Database\Eloquent\Model;

class ReturnOrderRequest extends Model
{
    use HasEnums;
    use DateScopesTrait;

    protected $guarded = [];
    protected $casts = ['shipping_started_at' => 'datetime', 'shipping_returned_at' => 'datetime', 'status' => 'int'];
    protected $enums = ['status' => ReturnOrderStatus::class];
    const REASONS = [
        "I don't want the product any more",
        "Wrong product was shipped",
        "Package arrived damaged",
        "Product doesn’t work",
        "Product doesn’t match the description",
        "Other",
    ];

    public function order() {
     
        return $this->belongsTo(Order::class);
    }

    public function billingAddress() {
     
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function shippingAddress() {
     
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function returnOrderItems() {
     
        return $this->hasMany(ReturnOrderItem::class, 'request_id');
    }

    public function getReasonAttribute($value) {
     
        return self::REASONS[$value];
    }

    public function scopeTotalReturn($q) {
        
        return $q->selectRaw("SUM(order_items.product_price * return_order_items.product_quantity) as Total")
        ->join('return_order_items', 'return_order_requests.id', 'return_order_items.request_id')
        ->join('order_items', 'return_order_items.order_item_id', 'order_items.id')
        ->whereNotIn('return_order_requests.status', [
            ReturnOrderStatus::pending()->getIndex(), 
            ReturnOrderStatus::rejected()->getIndex()
        ]);
    }
}
