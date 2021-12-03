<?php

namespace App\Providers;

use App\Models\BlogCategory;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SiteSettings;
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
        view()->composer(['layouts.app.index', 'pages.shop.*', 'pages.product.index', 'pages.landing_page.*'], function ($view) {
            $view->with('categories', Cache::rememberForever('categories', function () {
                return Category::with('subcategories:id,category_id,subcategory_name,subcategory_slug')->get();
            }));
        });
        view()->composer(['layouts.app.index', 'pages.shop.*', 'pages.product.index'], function ($view) {
            $view->with('brands', Cache::rememberForever('brands', function () {
                return Brand::orderBy('id')->get();
            }));
        });
        view()->composer(['layouts.app.index', 'pages.contact'], function ($view) {
            $view->with('site_settings', Cache::rememberForever('site_settings', function () {
                return (object) config('shop'); 
            }));
        });
        view()->composer(['layouts.app.index'], function ($view) {
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

    // private function getComposer($name, $set) 
    // {
    //     return  view()->composer('*', function ($view) use ($name, $set) {
    //         if (strstr($view->getName(), ".", true) != 'admin') {
    //             $view->with($name, $set);
    //         }
    //     });
    // }
}
