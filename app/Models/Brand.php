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

    const BRANDS_STOREAGE =  'media/brands';

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => CacheBrand::class,
        'updated' => CacheBrand::class,
        'deleted' => CacheBrand::class,
    ];

    public function getBrandLogoAttribute($value) {

        return asset($value ? 'storage/'. $value : 'storage/media/default.png');
    }

    public function products() {
     
        return $this->hasMany(Product::class)->select(
            [
                'products.id','products.category_id','products.subcategory_id','products.brand_id',
                'product_name','product_slug','selling_price',
                'product_quantity','discount_price','status','cover'
            ]);
    }

    public function sluggable(): array
    { 
        return [
            'brand_slug' => [
                'source' => 'brand_name',
                'onUpdate' => true
            ]
        ];
    }

}
