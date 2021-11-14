<?php

namespace App\Models;

use App\Events\CacheCategories;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Subcategory extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $guarded = [];
    protected $dispatchesEvents = [
        'created' => CacheCategories::class,
        'updated' => CacheCategories::class,
        'deleted' => CacheCategories::class,
    ];

    public function category() {
     
        return $this->belongsTo(Category::class);
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
            'subcategory_slug' => [
                'source' => 'subcategory_name',
                'onUpdate' => true
            ]
        ];
    }
}
