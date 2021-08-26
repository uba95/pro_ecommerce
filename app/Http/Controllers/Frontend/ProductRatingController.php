<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductRatingController extends Controller
{
    public function store(Product $product, Request $request) {

        // return current_user()->ratings()->updateOrCreate(['product_id' => $product->id], ['value' => $request->rating * 10]);
		return current_user()->productRatings()->syncWithoutDetaching([$product->id => ['value' => $request->rating * 10]]);
    
	}

    public function destroy(Product $product) {

        // return current_user()->ratings()->where('product_id', $product->id)->delete();
		 return current_user()->productRatings()->detach($product->id);
    }

}
