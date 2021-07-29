<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\forgetCacheCategories;

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