<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $guarded = [];
    protected $dispatchesEvents = [
        'created' => forgetCacheCategories::class,
        'updated' => forgetCacheCategories::class,
        'deleted' => forgetCacheCategories::class,
    ];

    public function category() {
     
        return $this->belongsTo(Category::class);
    }
}
