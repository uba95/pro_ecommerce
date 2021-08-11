<?php

namespace App\Models;

use App\Events\CacheBrand;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => CacheBrand::class,
        'updated' => CacheBrand::class,
        'deleted' => CacheBrand::class,
    ];

    public function getBrandLogoAttribute($value) {

        return asset($value ? 'storage/'. $value : 'storage/media/brands/default-logo.png');
    }

    public function products() {
     
        return $this->hasMany(Product::class)->select(
            [
                'id','category_id','subcategory_id','brand_id','product_name','product_slug','selling_price',
                'product_quantity','discount_price','status','hot_new','image_one'
            ]);
    }

    public function sluggable(): array
    { 
        return [
            'brand_slug' => [
                'source' => 'brand_name'
            ]
        ];
    }

}
