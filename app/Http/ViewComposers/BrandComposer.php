<?php
namespace App\Http\ViewComposers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class BrandComposer {
    
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    public function composer(View $view) {
        return $view->with('brands', Cache::rememberForever('brands', function () {
            return Brand::orderBy('id')->pluck('brand_name', 'brand_slug');
        }));
    }
}