<?php

namespace App\Models;

use App\Enums\OrderItemStatus;
use App\Models\Product;
use App\Traits\DateScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Enum\Laravel\HasEnums;

class OrderItem extends Model
{
    use HasEnums;
    use DateScopesTrait;

    protected $guarded = [];
    protected $casts = ['status' => 'int'];
    protected $enums = ['status' => OrderItemStatus::class];

    public function product() {
     
        return $this->belongsTo(Product::class);
    }

    public function order() {
     
        return $this->belongsTo(Order::class);
    }

    public function cancelOrderItems() {
     
        return $this->hasMany(CancelOrderItem::class);
    }

    public function returnOrderItems() {
     
        return $this->hasMany(ReturnOrderItem::class);
    }

    public function getTotalPriceAttribute() {
        return calculateTotalPrice($this->product_price, $this->product_quantity);
    }

    // public function scopeLast30days($q) {
    //     return $q->whereBetween('order_items.created_at', [now()->subDays(30), now()]);
    //     // return $q->whereDate('order_items.created_at', '>', now()->subDays(30));
    // }

    public static function withCancelableQuantities($orderItems) {

        return $orderItems->filter(fn($v) => $v->product_quantity > 0)->values();
        // return tap($orderItems)
        // ->map(fn($v) => $v->product_quantity -=  $v->cancelOrderItems()->sum('product_quantity'))
        // ->filter(fn($v) => $v->product_quantity > 0)->values();
    }

    public static function cancelableQuantitiesRequset($orderItems, $quantity) {

        $orderItemsCancelableQuantities = self::withCancelableQuantities($orderItems);
        return $orderItemsCancelableQuantities->every(fn($v, $k) => $v->product_quantity >= $quantity[$k]) 
        ? tap($orderItemsCancelableQuantities)->map(fn($v, $k) => $v->product_quantity = $quantity[$k])
        : null;
    }

    public static function withReturnableQuantities($orderItems) {

        return tap($orderItems)
        ->map(fn($v) => $v->product_quantity -=  $v->returnOrderItems()->sum('product_quantity'))
        ->filter(fn($v) => $v->product_quantity > 0)->values();
    }

    public static function returnableQuantitiesRequset($orderItems, $quantity) {

        $orderItemsReturnableQuantities = self::withReturnableQuantities($orderItems);
        return $orderItemsReturnableQuantities->every(fn($v, $k) => $v->product_quantity >= $quantity[$k]) 
        ? tap($orderItemsReturnableQuantities)->map(fn($v, $k) => $v->product_quantity = $quantity[$k])
        : null;
    }
}
