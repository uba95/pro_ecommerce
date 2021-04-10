<?php

namespace App\Model;

use App\Model\WishlistItem;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $guarded = [];

    public function wishlistItems() {
        return $this->hasMany(WishlistItem::class);
    }
}
