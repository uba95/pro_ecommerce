<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\CanBeBought;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Query\Builder;

class Product extends Model implements Buyable
{
    use CanBeBought;
    use Sluggable;
    use SluggableScopeHelpers;

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

    public function getDiscountPercentAttribute() {
        return intval((($this->selling_price - $this->discount_price) / $this->selling_price) * 100);
    }

    public function getStockStatusAttribute() {
        return $this->product_quantity > 5 ? "in" : ($this->product_quantity == 0 ? "out" : "only");
    }

    public function  scopeSelection($q){
        return $q->select('products.id','brand_id', 'product_name', 'product_slug', 'product_quantity', 'selling_price', 'discount_price', 'main_slider', 'hot_deal', 'best_rated', 'mid_slider', 'hot_new', 'trend', 'image_one', 'status');
    }

    public function  scopeFilterPrice($q, $min, $max){
        return $q->whereRaw('
        CASE 
            WHEN discount_price IS NULL 
            THEN selling_price 
            ELSE discount_price 
        END 
        BETWEEN ? AND ?', 
        [$min, $max]);
    }
    
    public function  scopeSearch($q, $search, $category) {
        return $q->where(fn($q) => $q->where('product_name', 'LIKE', "%${search}%")
        ->orWhere('product_details', 'LIKE', "%${search}%"))
        ->when($category, fn($q, $category) => $q->where('category_slug', $category));
    }

    public function sluggable(): array
    { 
        return [
            'product_slug' => [
                'source' => 'product_name'
            ]
        ];
    }

}
