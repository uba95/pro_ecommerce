<?php
namespace App\Http\ViewComposers;

use App\Models\BlogCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class BlogCategoryComposer {
    
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    public function composer(View $view) {
        return $view->with('blogCategories', Cache::rememberForever('blogCategories', function () {
            return BlogCategory::orderBy('id')->pluck('blog_category_name', 'blog_category_slug');
        }));
    }
}