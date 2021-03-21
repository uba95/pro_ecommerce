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
     
        return view('pages.wishlist', ['wishlist_products' => Product::wishlistProducts()]);
    }
    
    public function store($id) {


        $product = Product::find($id);

        if (!$product) {

            return Response::json(['error' => 'Product Not Found']);	 
        }

        $userid = Auth::id();
        $wishlist = Wishlist::where('user_id', $userid)->where('product_id', $id)->first();
        
        if (Auth::Check()) {
        
            if ($wishlist) {

                $wishlist->delete();
                $countWishlist =  Auth::user()->wishlist()->count();
                return Response::json(['success' => 'Product Deleted From Your Wishlist', 'countWishlist' => $countWishlist]);	 
            } else {

                Wishlist::create(['user_id' => $userid, 'product_id' => $id]);
                $countWishlist =  Auth::user()->wishlist()->count();

                return Response::json(['success' => 'Product Added To Your Wishlist', 'countWishlist' => $countWishlist]);
            }
        
        } else {

            return Response::json(['error' => 'You Need To Log in First']);      
        } 
    
    
    }
}
