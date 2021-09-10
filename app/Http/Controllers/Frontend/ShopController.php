<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ShopProductsService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShopController extends Controller
{
    public function index(Request $request) {

        if (($request->model && !in_array($request->model, ['category', 'subcategory', 'brand'])) 
            || (!$request->slug &&  !$request->search)) {
                throw new ModelNotFoundException;
        }

        if ($request->slug) {
            $find =  ShopProductsService::getModel($request->model)
            ->findBySlug($request->slug)
            ->sortBy($request->sort, $request->order);            
            $products = $find->getModelProducts();
        } 
        
        if ($request->search) {
            $find =  ShopProductsService::getModel('Product')
            ->sortBy($request->sort, $request->order);
            $products = $find->searchProducts($request->search, $request->category, $request->subcategory, $request->brand);
        } 

        if ($request->expectsJson()) {
            $filteredProducts = $products->filterPrice($request->min, $request->max)->paginate(3);

            $sort_html =  view('pages.shop.sort')->render();
            $pagination = $filteredProducts->appends(request()->except('page'))->links('vendor.pagination.shop')->render();
            $products = view('pages.shop.product', ['products' => $filteredProducts])->render();

            return response()->json(compact('products', 'sort_html', 'pagination'));    
        } 
        
        return view('pages.shop.index', [
            'model' => $find->modelData,
            'products' => $products->paginate(3),
            'homeTitle' => $find->getTitle($request->search)
        ]);
    }
}