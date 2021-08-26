<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowProductController extends Controller
{
    public function __invoke(Product $product) {

        $rate = optional(current_user())->theirProductRating($product->id);
        return view('pages.product', compact('product', 'rate') + [
            'productRatingAvg' => $product->ratingAvg,
            'userRating' =>  number_format($rate / 10, 1),
        ]);
    }
}
