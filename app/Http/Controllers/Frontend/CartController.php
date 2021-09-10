<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Shipment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Response;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    
    private function cart($push = []) {

        return Response::json(array_merge([
            'cart_count' =>  Cart::count(),
            'cart_price' => Cart::priceTotal(),
        ], $push));
    }

    public function show() {
        return view('pages.cart', [
            'cart_products' => Cart::content(),
            'products' => DB::table('products')->get(['id', 'product_quantity']),
        ]);
    }
    
    public function store($id) {
        
        $product = Product::where('id', $id)->whereEnum('status', 'active')->firstOrFail();

        Cart::add($product, request()->product_quantity, [
            'color' => request()->product_color,
            'size' => request()->product_size,
            'image' => $product->cover,
        ]);

        return $this->cart(['success' => 'Product Added To Your Cart']);
    }

    public function update($rowId) {
     
        $item = Cart::update($rowId, request('val'));
        return $this->cart(['cartItem_price' => round($item->qty * $item->price, 2)]);
    }

    public function destroy($rowId) {
     
        Cart::remove($rowId);
        return $this->cart();
    }

    public function destroyAll() {
     
        Cart::destroy();
        return $this->cart();
    }
}
