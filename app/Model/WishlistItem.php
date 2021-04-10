<?php

namespace App\Model;

use App\Model\Admin\Product;
use Illuminate\Database\Eloquent\Model;

class WishlistItem extends Model
{
    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}