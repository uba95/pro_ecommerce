<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class WishlistController extends Controller
{
    public function index() {
     
        return view('pages.wishlist', ['wishlist_items' => Auth::user()->wishlistItems]);
    }
    
    public function store(Product $product) {

        $countWishlist =  Auth::user()->wishlistItems()->count();

        return Auth::user()->wishlistItems()->toggle($product)['attached'] 
        ? Response::json(['success' => 'Product Added To Your Wishlist', 'countWishlist' => ++$countWishlist])
        : Response::json(['success' => 'Product Deleted From Your Wishlist', 'countWishlist' => --$countWishlist]);
    }
}