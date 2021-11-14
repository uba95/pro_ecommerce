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
    public function __invoke(Product $product, Request $request) {

        abort_if(!$product->status->isActive(), 404);

        if (!collect(Session::get('recently_viewed'))->contains('id', $product->id)) {
            Session::push('recently_viewed', $product);
            Session::save();
        }
        
        $rate = optional(current_user())->theirProductRating($product->id);

        if ($request->expectsJson()) {

            $newReviews = $product->reviews()->with('user')->latest()->paginate(3);
            $pagination = $newReviews->appends(request()->except('page'))->links('vendor.pagination.shop')->render();
            $reviews = view('pages.product.reviews_media', ['reviews' => $newReviews, 'product' => $product])->render();
            $newReviews->each(fn($v) => $v->rating = $product->userReviewRating($v->user->id));
            return response()->json(compact('reviews', 'pagination', 'newReviews'));    
        } 
        
        $ratingAgg = $product->ratingAgg;

        return view('pages.product.index', [
            'product'           => $product,
            'rate'              => (float) $rate,
            'avgRating'               => number_format($ratingAgg->first() / 10, 1),
            'countRating'             => $ratingAgg->keys()->first(),
        ]);
    }
}
