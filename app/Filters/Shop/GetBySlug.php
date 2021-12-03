<?php
namespace App\Filters\Shop;

use App\Services\ShopProductsService;
use Closure;

class GetBySlug
{
  public function handle($request, Closure $next) {

    if ($request->slug) {
      $model =  ShopProductsService::getModel($request->model)
      ->findBySlug($request->slug)
      ->sortBy($request->sort, $request->order);   

      $products = $model->getModelProducts();
      return compact('model', 'products');
    } 

    return $next($request);
  }
}
