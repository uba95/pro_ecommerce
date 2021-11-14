<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\HotDealProduct;
use App\Models\LandingPageItem;
use App\Models\Product;
use App\Services\ReportService;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function __invoke()
    {
        $featured_products = Product::active()->selection2()->inRandomOrder()->limit(18)->get();

        $trend_products = ReportService::mostSoldProducts(18)->map->product;

        $best_rated_products = Product::selection2()
        ->orderByRaw('(SELECT AVG(value) FROM product_ratings WHERE products.id = product_ratings.product_id) DESC')
        ->limit(18)
        ->get();

        $hot_deal_products =  HotDealProduct::with([
            'product' => fn($q) => $q->selection2()->soldQuantities()
        ])->whereHas('product' ,  fn($q) => $q->where('product_quantity', '>', 0)->active())
        ->where('started_at', '<', now())
        ->active()
        ->latest()
        ->get();

        $new_arrivals_products = Product::selection2()->lastdays(30)->latest()->limit(20)->get();

        $discounts_products = Product::selection2()->with(['ratings' => fn($q) => $q->getAvg()])
        ->whereNotNull('discount_price')
        ->latest()
        ->limit(20)
        ->get();

        $trend_year_products = ReportService::mostSoldProducts(10, 'lastdays', 365)->map->product;

        $landing_page_items = LandingPageItem::active()
        ->with([ 
            'product:id,category_id,product_name,product_slug,discount_price,selling_price', 
            'product.ratings' => fn($q) => $q->getAvg()
        ])
        ->get();

        $main_banner = $landing_page_items->filter(fn($v) => $v->is_main_banner)->random();

        $banner_slider_items = $landing_page_items->filter(fn($v) => $v->is_banner_slider);

        $ad_count = $landing_page_items->filter(fn($v) => $v->is_advert)->count();
        $adverts = $landing_page_items->filter(fn($v) => $v->is_advert)->random($ad_count < 3 ? $ad_count : 3);

        return view('pages.landing_page.index', compact('main_banner', 'featured_products', 'trend_products', 'best_rated_products', 'hot_deal_products', 'banner_slider_items', 'adverts', 'new_arrivals_products', 'discounts_products', 'trend_year_products'));
    }
}
