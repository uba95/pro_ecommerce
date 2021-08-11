<?php

namespace App\Events;

use App\Models\BlogCategory;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CacheBlogCategories
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        Cache::forget('blogCategories');
        Cache::rememberForever('blogCategories', function () {
            return BlogCategory::orderBy('id')->pluck('blog_category_name', 'id');
        });
    }
}
