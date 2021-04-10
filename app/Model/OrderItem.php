<?php

namespace App\Model;

use App\Model\Admin\Product;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];

    public function product() {
     
        return $this->belongsTo(Product::class);
    }

    public function order() {
     
        return $this->belongsTo(Order::class);
    }

    public function returnOrderItems() {
     
        return $this->hasMany(ReturnOrderItem::class);
    }

    public static function withReturnableQuantities($orderItems) {

        return tap($orderItems)
        ->map(fn($v) => $v->product_quantity -=  $v->returnOrderItems()->sum('product_quantity'))
        ->filter(fn($v) => $v->product_quantity > 0)->values();
    }

    public static function returnableQuantitiesRequset($orderItems, $quantity) {

        $orderItemsReturnableQuantities = OrderItem::withReturnableQuantities($orderItems);
        return $orderItemsReturnableQuantities->every(fn($v, $k) => $v->product_quantity >= $quantity[$k]) 
        ? tap($orderItemsReturnableQuantities)->map(fn($v, $k) => $v->product_quantity = $quantity[$k])
        : null;
    }
}
