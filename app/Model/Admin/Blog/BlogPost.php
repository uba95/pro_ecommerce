<?php

namespace App\Model\Admin\Blog;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $guarded = [];

    public function category() {
     
        return $this->belongsTo(BlogCategory::class);
    }
    
    public function getPostImageAttribute($value) {

        return asset($value ? 'storage/'. $value : 'storage/media/brands/default-logo.png');
    }

}
