<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function __invoke()
    {
        // $categories = Category::with('subcategories:category_id,subcategory_name')->get();
        // $categories = DB::table('categories')->get();
        // $subcategories = DB::table('subcategories')->get();

        // $featured_products = Product::selection()->where('status', 1)->with('brand:id,brand_name')->latest()->get();
        // productSelectScope(DB::table('products')->where('status', 1)->join('brands', 'products.brand_id', 'brands.id')->addSelect('brands.brand_name'))->latest('products.created_at')->get();
        $featured_products = Product::where('status', 1)->join('brands', 'products.brand_id', 'brands.id')
        ->selection()->addSelect('brands.brand_name')->latest('products.created_at')->get();

        $main_slider_product = $featured_products->filter(fn($v) => $v->main_slider == 1)[0];
        $trend_products = $featured_products->filter(fn($v) => $v->trend == 1);
        $best_rated_products = $featured_products->filter(fn($v) => $v->best_rated == 1);
        $hot_deal_products = $featured_products->filter(fn($v) => $v->hot_deal == 1);
        $mid_slider_products = $featured_products->filter(fn($v) => $v->mid_slider == 1);

        return view('pages.index', compact('main_slider_product', 'featured_products', 'trend_products', 'best_rated_products', 'hot_deal_products', 'mid_slider_products'));
    }
}
