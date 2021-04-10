<?php

namespace App\Model;

use App\Model\Order;
use App\Enums\ReturnOrderStatus;
use Spatie\Enum\Laravel\HasEnums;
use Illuminate\Database\Eloquent\Model;

class ReturnOrderRequest extends Model
{
    use HasEnums;
    
    protected $guarded = [];
    protected $casts = ['shipping_started_at' => 'datetime', 'shipping_returned_at' => 'datetime', 'status' => 'int'];
    protected $enums = ['status' => ReturnOrderStatus::class];

    public function order() {
     
        return $this->belongsTo(Order::class);
    }

    public function billingAddress() {
     
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function shippingAddress() {
     
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function returnOrderItem() {
     
        return $this->hasMany(ReturnOrderItem::class, 'request_id');
    }

    public function getReasonAttribute($value) {
     
        return [
            "I don't want the product any more",
            "Wrong product was shipped",
            "Package arrived damaged",
            "Product doesn’t work",
            "Product doesn’t match the description",
            "Other",
        ][$value];
    }

}
