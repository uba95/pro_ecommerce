<?php

namespace App\Http\Controllers\Frontend;

use App\Filters\Shop\CheckParameters;
use App\Filters\Shop\GetBySearch;
use App\Filters\Shop\GetBySlug;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ShopProductsService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pipeline\Pipeline;

class ShopController extends Controller
{
    public function index(Request $request) {

        $data = app(Pipeline::class)
            ->send($request)
            ->through([
                CheckParameters::class,
                GetBySlug::class,
                GetBySearch::class,
            ])
            ->thenReturn();

        $products = $data['products'];    
        $model = $data['model'];    
        

        if ($request->expectsJson()) {
            $filteredProducts = $products->filterPrice($request->min, $request->max)->paginate(20);

            $sort_html =  view('pages.shop.sort')->render();
            $pagination = $filteredProducts->appends(request()->except('page'))->links('vendor.pagination.shop')->render();
            $products = view('pages.shop.product', ['products' => $filteredProducts])->render();
            $products_count = $filteredProducts->total();

            return response()->json(compact('products', 'sort_html', 'pagination', 'products_count'));    
        } 
        
        return view('pages.shop.index', [
            'model' => $model->modelData,
            'products' => $products->paginate(20),
            'homeTitle' => $model->getTitle($request->search)
        ]);
    }
}