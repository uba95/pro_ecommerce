<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Admin\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class WishlistController extends Controller
{
    public function index() {
     
        return view('pages.wishlist', [
            'wishlist_items' => Auth::user()->wishlistItems()->with('product:id,product_name,selling_price,discount_price,hot_new,image_one')->get()
        ]);
    }
    
    public function store(Product $product) {

        $wishlistItem = Auth::user()->wishlistItems->where('product_id', $product->id)->first();
        
        if ($wishlistItem) {

            $wishlistItem->delete();
            $countWishlist =  Auth::user()->wishlistItems()->count();
            return Response::json(['success' => 'Product Deleted From Your Wishlist', 'countWishlist' => $countWishlist]);	 
        } else {

            $wishlist = Auth::user()->wishlist()->first() ?? Auth::user()->wishlist()->create();
            $wishlist->wishlistItems()->create(['product_id' => $product->id]);
            $countWishlist =  Auth::user()->wishlistItems()->count();
            return Response::json(['success' => 'Product Added To Your Wishlist', 'countWishlist' => $countWishlist]);
        }
    }
}
