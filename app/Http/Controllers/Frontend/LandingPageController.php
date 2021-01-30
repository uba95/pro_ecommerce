<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Model\Admin\Category;
use App\Http\Controllers\Controller;
use App\Model\Admin\Product;

class LandingPageController extends Controller
{
    public function __invoke()
    {
        $categories = Category::with('subcategories:category_id,subcategory_name')->get();
        $featured_products = Product::selection()->where('status', 1)->with('brand:id,brand_name')->latest()->get();
        $main_slider_product = $featured_products->filter(fn($v) => $v->main_slider == 1)[0];
        $trend_products = $featured_products->filter(fn($v) => $v->trend == 1);
        $best_rated_products = $featured_products->filter(fn($v) => $v->best_rated == 1);
        $hot_deal_products = $featured_products->filter(fn($v) => $v->hot_deal == 1);
        $mid_slider_products = $featured_products->filter(fn($v) => $v->mid_slider == 1);

        return view('pages.index', compact('categories', 'main_slider_product', 'featured_products', 'trend_products', 'best_rated_products', 'hot_deal_products', 'mid_slider_products'));
    }
}
