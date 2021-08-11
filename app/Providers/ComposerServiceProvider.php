<?php

namespace App\Providers;

use App\Models\BlogCategory;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layouts.app', 'layouts.menubar', 'pages.shop.*'], function ($view) {
            $view->with('categories', Cache::rememberForever('categories', function () {
                return Category::with('subcategories:category_id,subcategory_name,subcategory_slug')->get();
            }));
        });
        view()->composer(['layouts.app', 'layouts.menubar', 'pages.shop.*'], function ($view) {
            $view->with('brands', Cache::rememberForever('brands', function () {
                return Brand::orderBy('id')->pluck('brand_name', 'brand_slug');
            }));
        });
        view()->composer(['layouts.app', 'layouts.menubar'], function ($view) {
            $view->with('blogCategories',Cache::rememberForever('blogCategories', function () {
                return BlogCategory::orderBy('id')->pluck('blog_category_name', 'blog_category_slug');
            }));
        });
        // $this->getComposer('categories', Cache::rememberForever('categories', function () {
        //     return Category::with('subcategories:category_id,subcategory_name,subcategory_slug')->get();
        // }));

        // $this->getComposer('brands', Cache::rememberForever('brands', function () {
        //     return Brand::orderBy('id')->pluck('brand_name', 'brand_slug');
        // }));

        // $this->getComposer('blogCategories', Cache::rememberForever('blogCategories', function () {
        //     return BlogCategory::orderBy('id')->pluck('blog_category_name', 'blog_category_slug');
        // }));
    }

    private function getComposer($name, $set) 
    {
        return  view()->composer('*', function ($view) use ($name, $set) {
            if (strstr($view->getName(), ".", true) != 'admin') {
                $view->with($name, $set);
            }
        });
    }
}
