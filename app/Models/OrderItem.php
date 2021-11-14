<?php

namespace App\Models;

use App\Models\Product;
use App\Traits\DateScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Enum\Laravel\HasEnums;

class OrderItem extends Model
{
    use DateScopesTrait;

    protected $guarded = [];

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

    public function scopeProductSoldQuantities($q) {
        return $q->selectRaw("
          order_items.product_id, order_items.product_name,
          SUM(order_items.product_quantity) AS sold_quantity,
          SUM(order_items.product_price * order_items.product_quantity) AS sales
        ")
        ->groupBy('order_items.product_id');
    }

    public function scopeNotCanceled($q) {
        return $q->where('product_quantity', '>', 0);
    }
}
