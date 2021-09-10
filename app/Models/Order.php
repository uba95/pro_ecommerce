<?php

namespace App\Models;

use App\Models\User;
use App\Enums\OrderStatus;
use App\Traits\DateScopesTrait;
use Spatie\Enum\Laravel\HasEnums;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasEnums;
    use DateScopesTrait;
    
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

    public function cancelOrderRequests() {     
        return $this->hasMany(CancelOrderRequest::class);
    }
    
    public function returnOrderRequests() {     
        return $this->hasMany(ReturnOrderRequest::class);
    }

    public function isCancelPending($value = ['pending']) {
        // return optional($this->cancelOrderRequest)->status == 'pending';
        // return $this->cancelOrderRequests->filter(fn($v) => $v->status == 'pending')->isNotEmpty();
        // return $this->cancelOrderRequests->filter(fn($v) => $v->status->getValue() == $value)->isNotEmpty();
        return $this->cancelOrderRequests->filter(fn($v) => in_array($v->status->getValue(), $value))->isNotEmpty();
    }

    public function isReturnPending($value = ['pending']) {
        return $this->returnOrderRequests->filter(fn($v) => in_array($v->status->getValue(), $value))->isNotEmpty();
        // return $this->returnOrderRequests->isNotEmpty()  ? $this->returnOrderRequests->every->status !== 0 : 0;
    }

    public function areAllItemsCanceled() {
        return $this->orderItems->sum('product_quantity') == 0;
        // return $this->cancelOrderRequests->map(fn($v) => $v->cancelOrderItems->sum('product_quantity'))
        //         == $this->orderItems->sum('product_quantity');
    }

    public function areSomeItemsCanceled() {
        return $this->isCancelPending(['approved', 'refunded']);
    }

    public function areSomeItemsReturned() {
        return $this->isReturnPending(['refunded', 'returned']);
    }

    public function areAllItemsReturned() {
        return $this->returnOrderRequests->map(fn($v) => $v->returnOrderItems->sum('product_quantity'))->sum()
                == $this->orderItems->sum('product_quantity');

                // return tap($orderItems)
                // ->map(fn($v) => $v->product_quantity -=  $v->returnOrderItems()->sum('product_quantity'))
                // ->filter(fn($v) => $v->product_quantity > 0)->values();
        
    }

    public function scopeSold($q) {
        return $q->whereNotEnum('status', ['pending']); 
    }

    public function itemsAreAvailable() {
        return $this->orderItems
                ->load('product:id,product_quantity')
                ->every(fn($v) => $v->product->product_quantity > $v->product_quantity);
    }

    public function decrementStock() {
        return $this->orderItems
                ->load('product:id,product_quantity')
                ->map(fn($v) => $v->product->decrement('product_quantity', $v->product_quantity));
    }

    public function returnStatus() {
        return $this->areAllItemsReturned() ? OrderStatus::returned() : OrderStatus::partiallyReturned();
    }
}
