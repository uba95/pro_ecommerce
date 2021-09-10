<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\CanBeBought;
use Cviebrock\EloquentSluggable\Sluggable;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Spatie\Enum\Laravel\HasEnums;

class Product extends Model implements Buyable
{
    use CanBeBought;
    use Sluggable;
    use SluggableScopeHelpers;
    use HasEnums;

    protected $guarded = [];
    protected $casts = ['product_color' => 'array', 'product_size' => 'array', 'status' => 'int'];
    protected $enums = ['status' => ProductStatus::class];

    public function category() {    
        return $this->belongsTo(Category::class);
    }

    public function subcategory() {    
        return $this->belongsTo(Subcategory::class);
    }

    public function brand() {     
        return $this->belongsTo(Brand::class);
    }

    public function images() {     
        return $this->hasMany(ProductImage::class);
    }

    public function ratings() {
        
        return $this->hasMany(ProductRating::class);
    }

    public function hotDeal() {
        
        return $this->hasOne(HotDealProduct::class);
    }

    public function meta() {
        
        return $this->hasOne(ProductMeta::class);
    }

    // public function getUserRateAttribute() {
        
    //     return optional($this->ratings->firstWhere('user_id', Auth::id()))->value;
    // }

    public function getRatingAvgAttribute() {
        
        return number_format($this->ratings()->avg('value') / 10, 1);
    }

    public function getCoverAttribute($value) {
        return asset($value ? 'storage/'. $value : 'storage/media/default.png');
    }

    public function getDiscountPercentAttribute() {
        return intval((($this->selling_price - $this->discount_price) / $this->selling_price) * 100);
    }

    public function getStockStatusAttribute() {
        return $this->product_quantity > 5 ? "in" : ($this->product_quantity == 0 ? "out" : "only");
    }
    
    public function getVideoEmbedAttribute() {
        return Str::contains($this->video_link, 'youtube.com')
        ? 'https://www.youtube.com/embed/' . substr(strrchr($this->video_link, "v="), 2) 
        : '';
    }

    public function  scopeSelection($q){
        return $q->select('products.id','products.brand_id', 'products.category_id', 'products.subcategory_id', 'product_name', 'product_slug', 'product_quantity', 'selling_price', 'discount_price', 'main_slider', 'hot_deal', 'best_rated', 'mid_slider', 'hot_new', 'trend', 'cover', 'status');
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
    
    public function  scopeSearch($q, $search, $category, $subcategory, $brand) {
        return $q->where(fn($q) => $q->where('product_name', 'LIKE', "%${search}%")
        ->orWhere('product_details', 'LIKE', "%${search}%"))
        ->when($category, fn($q) => $q->where('category_slug', $category))
        ->when($subcategory, fn($q) => $q->where('subcategory_slug', $subcategory))
        ->when($brand, fn($q) => $q->where('brand_slug', $brand))
        ;

    }
    public function  scopeShop($q) {
        $q->addSelect('categories.*')
        ->leftJoin('categories', 'products.category_id', 'categories.id')
        ->addSelect('subcategories.*')
        ->leftJoin('subcategories', 'products.subcategory_id', 'subcategories.id')
        ->addSelect('brands.*')
        ->leftJoin('brands', 'products.brand_id', 'brands.id');
    }

    public function sluggable(): array
    { 
        return [
            'product_slug' => [
                'source' => 'product_name',
                'onUpdate' => true
            ]
        ];
    }

}
