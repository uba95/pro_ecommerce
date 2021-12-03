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
            'cart_products' => $c = Cart::content(),
            'products' => Product::whereIn('id', $c->pluck('id'))->pluck('product_quantity', 'id'),
        ]);
    }
    
    public function store($productId, Request $request) {
        
        $product = Product::where('id', $productId)->active()->firstOrFail();

        if (!intval($request->product_quantity)) {
            return response()->json(['error' => 'This Quantity Is Not Valid']);
        }

        Cart::add($product, $request->product_quantity, [
            'color' => $request->product_color,
            'size' => $request->product_size,
            'image' => $product->cover,
            'slug' => $product->product_slug,
        ]);

        return $this->cart(['success' => 'Product Added To Your Cart']);
    }

    public function update($rowId, Request $request) {

        if (Cart::search(fn($v, $k) => $k == $rowId)->isEmpty()) {
            return response()->json(['error' => 'Cart Item Not Found']);
        }

        if (!intval($request->quantity)) {
            return response()->json(['error' => 'This Quantity Is Not Valid']);
        }
 
        $item = Cart::update($rowId, $request->quantity);
        return $this->cart(['cartItem_price' => round($item->qty * $item->price, 2)]);
    }

    public function destroy($rowId) {
        
        if (Cart::search(fn($v, $k) => $k == $rowId)->isEmpty()) {
            return response()->json(['error' => 'Cart Item Not Found']);
        }

        Cart::remove($rowId);
        return $this->cart();
    }

    public function destroyAll() {
     
        Cart::destroy();
        return $this->cart();
    }
}
