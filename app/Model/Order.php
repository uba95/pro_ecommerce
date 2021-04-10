<?php

namespace App\Model;

use App\User;
use App\Enums\OrderStatus;
use Spatie\Enum\Laravel\HasEnums;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasEnums;
    
    protected $guarded = [];
    protected $casts = ['status' => 'int'];
    protected $enums = ['status' => OrderStatus::class];

    public function orderItems() {
     
        return $this->hasMany(OrderItem::class);
    }

    public function shipment() {
     
        return $this->hasOne(Shipment::class);
    }

    public function user() {
     
        return $this->belongsTo(User::class);
    }

    public function address() {
     
        return $this->belongsTo(Address::class);
    }

    public function cancelOrderRequest() {
     
        return $this->hasOne(CancelOrderRequest::class);
    }
    
    public function returnOrderRequests() {
     
        return $this->hasMany(ReturnOrderRequest::class);
    }

    public function isCancelPending() {

        return optional($this->cancelOrderRequest)->status == 'pending';
    }

    public function isReturnPending() {

        return $this->returnOrderRequests->filter(fn($v) => $v->status == 'pending')->isNotEmpty();
        // return $this->returnOrderRequests->isNotEmpty()  ? $this->returnOrderRequests->every->status !== 0 : 0;
    }
}
