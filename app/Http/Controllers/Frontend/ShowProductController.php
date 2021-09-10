<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ShowProductController extends Controller
{
    public function __invoke(Product $product) {

        abort_if(!$product->status->isActive(), 404);

        if (!collect(Session::get('view_products'))->contains('id', $product->id)) {
            Session::push('view_products', $product);
            Session::save();
        }
        
        $rate = optional(current_user())->theirProductRating($product->id);

        return view('pages.product', [
            'product'           => $product,
            'rate'              => $rate,
            'productRatingAvg'  => $product->ratingAvg,
            'userRating'        =>  number_format($rate / 10, 1),
        ]);
    }
}
