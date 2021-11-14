<?php

namespace App\Models;

use App\Events\CacheCategories;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => CacheCategories::class,
        'updated' => CacheCategories::class,
        'deleted' => CacheCategories::class,
    ];

    public function subcategories() {
     
        return $this->hasMany(Subcategory::class);
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
            'category_slug' => [
                'source' => 'category_name',
                'onUpdate' => true
            ]
        ];
    }

}
