<?php

namespace App\Model\Admin;

use App\Events\forgetCacheCategories;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => forgetCacheCategories::class,
        'updated' => forgetCacheCategories::class,
        'deleted' => forgetCacheCategories::class,
    ];

    public function subcategories() {
     
        return $this->hasMany(Subcategory::class);
    }
}
