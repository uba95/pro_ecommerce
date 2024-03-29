<?php
namespace App\Http\ViewComposers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CategoryComposer {
    
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    public function composer(View $view) {
        return $view->with('categories', Cache::rememberForever('categories', function () {
            return Category::with('subcategories:category_id,subcategory_name,subcategory_slug')->get();
        }));
    }
}