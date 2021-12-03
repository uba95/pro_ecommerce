<?php
namespace App\Filters\Shop;

use App\Services\ShopProductsService;
use Closure;

class GetBySearch
{
  public function handle($request, Closure $next) {

    if ($request->search) {
      $model =  ShopProductsService::getModel('Product')->sortBy($request->sort, $request->order);
      $products = $model->searchProducts($request->search, $request->category, $request->subcategory, $request->brand);
      return compact('model', 'products');
    } 

    return $next($request);
  }
}
