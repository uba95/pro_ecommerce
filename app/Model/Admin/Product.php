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


}
