<?php

namespace App\Model\Admin;

use App\Model\Frontend\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\CanBeBought;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Query\Builder;

class Product extends Model implements Buyable
{
    use CanBeBought;
    
    protected $guarded = [];

    public function category() {
     
        return $this->belongsTo(Category::class);
    }

    public function subcategory() {
     
        return $this->belongsTo(Subcategory::class);
    }

    public function brand() {
     
        return $this->belongsTo(Brand::class);
    }

    public function wishlist() {
     
        return $this->hasMany(Wishlist::class);
    }
    
    public function getImageOneAttribute($value) {

        return asset($value ? 'storage/'. $value : 'storage/media/brands/default-logo.png');
    }
    public function getImageTwoAttribute($value) {

        return asset($value ? 'storage/'. $value : 'storage/media/brands/default-logo.png');
    }
    public function getImageThreeAttribute($value) {

        return asset($value ? 'storage/'. $value : 'storage/media/brands/default-logo.png');
    }

    public function getProductColorAttribute($value) {

        return json_decode($value);
    }

    public function getProductSizeAttribute($value) {

        return json_decode($value);
    }

    public function  scopeSelection( $q){

        return $q -> select('products.id','brand_id', 'product_name', 'product_quantity', 'selling_price', 'discount_price', 'main_slider', 'hot_deal', 'best_rated', 'mid_slider', 'hot_new', 'trend', 'image_one', 'status');

    }

    public function isOnUserWishlist($user = null) {

        return $this->wishlist->where('user_id', $user ?? Auth::id())->isNotEmpty();
    }

    public function getDiscountPercentAttribute() {

        return intval((($this->selling_price - $this->discount_price) / $this->selling_price) * 100);
    }

}
