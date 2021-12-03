<?php
namespace App\Filters\Shop;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CheckParameters
{
  public function handle($request, Closure $next) {

    if (($request->model && !in_array($request->model, ['category', 'subcategory', 'brand'])) || 
      (!$request->slug &&  !$request->search)) {
        throw new ModelNotFoundException();
    }

    return $next($request);
  }
}
