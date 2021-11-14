<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductReviewRequest;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index() {
        return view('pages.reviews.index', ['reviews' => current_user()->reviews()->with('product.ratings')->latest()->paginate(3)]);
    }

    public function store(Product $product, ProductReviewRequest $request) {

        if (current_user()->productReviews()->where('product_id',  $product->id)->exists()) {
            return response()->json(['error' => 'You Already Reviewed This Product']);
        }

        current_user()->productReviews()->attach($product->id, $request->validated());

        return response()->json(['success' => 'Your Review Has Been Successfully Published']);
    }

    public function edit(Product $product) {

        $review = current_user()->theirProductReview($product->id);

        if (!$review) {
            throw  (new ModelNotFoundException)->setModel(ProductReview::class);
        }

        return view('pages.reviews.edit', [
            'product' => $product,
            'review' => $review,
            'rate' =>  (float) current_user()->theirProductRating($product->id),
        ]);
    }

    public function update(Product $product, ProductReviewRequest $request) {
        current_user()->productReviews()->syncWithoutDetaching([$product->id => $request->validated()]);
        return redirect()->route('reviews.index', $product->product_slug)->with(toastNotification('Your Review Has Been Successfully Updated'));
    }

    public function destroy(Product $product) {
		current_user()->productReviews()->detach($product->id);
        return redirect()->route('reviews.index')->with(toastNotification('Review', 'deleted'));
    }
}
