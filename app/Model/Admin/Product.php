<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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

    public function  scopeSelection($q){

        return $q -> select('id','brand_id', 'product_name', 'product_quantity', 'selling_price', 'discount_price', 'main_slider', 'hot_deal', 'best_rated', 'mid_slider', 'hot_new', 'trend', 'image_one', 'status');

    }

}
