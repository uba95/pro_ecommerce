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
                'id','category_id','subcategory_id','brand_id','product_name','product_slug','selling_price',
                'product_quantity','discount_price','status','hot_new','cover'
            ]);
    }

    public function sluggable(): array
    { 
        return [
            'subcategory_slug' => [
                'source' => 'subcategory_name'
            ]
        ];
    }
}
