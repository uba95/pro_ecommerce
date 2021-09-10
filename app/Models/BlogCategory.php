<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\CacheBlogCategories;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class BlogCategory extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => CacheBlogCategories::class,
        'updated' => CacheBlogCategories::class,
        'deleted' => CacheBlogCategories::class,
    ];

    public function posts() {

        return $this->hasMany(BlogPost::class, 'category_id');
    }

    public function sluggable(): array
    {
        return [
            'blog_category_slug' => [
                'source' => 'blog_category_name',
                'onUpdate' => true
            ]
        ];
    }

}
