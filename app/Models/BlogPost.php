<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    protected $guarded = [];

    public function category() {
     
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
    
    public function getPostImageAttribute($value) {

        return asset($value ? 'storage/'. $value : 'storage/media/default.png');
    }

    public function sluggable(): array
    {
        return [
            'post_slug' => [
                'source' => 'post_title',
                'onUpdate' => true
            ]
        ];
    }

}
