<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Admin\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    
    public function cart($push = []) {

        return Response::json(array_merge([
            'cart_count' =>  Cart::count(),
            'cart_price' => Cart::subtotal(),
        ], $push));
    }

    public function show() {
        // dd(Cart::content(), Cart::subtotal(), Cart::total(), Cart::priceTotal());
        return view('pages.cart', [
            'cart_products' => Cart::content(),
            // 'categories' =>  DB::table('categories')->get(),
            // 'subcategories' => DB::table('subcategories')->get(),
            'products' => DB::table('products')->get(['id', 'product_quantity']),
        ]);
    }
    
    public function store($id) {
        
        $product = Product::findOrFail($id);

        Cart::add($product, request()->product_quantity, [
            'image' => $product->image_one,
            'color' => request()->product_color,
            'size' => request()->product_size,
            ]);

        return $this->cart(['success' => 'Product Added To Your Cart']);
    }

    public function update($rowId) {
     
        $item = Cart::update($rowId, request('val'));
        return $this->cart(['cartItem_price' => $item->qty * $item->price]);
    }

    public function destroy($rowId) {
     
        Cart::remove($rowId);
        return $this->cart();
    }

    public function destroyAll() {
     
        Cart::destroy();
        return $this->cart();
    }


    public function checkout() {
     
        return view('pages.checkout');
    }
}
