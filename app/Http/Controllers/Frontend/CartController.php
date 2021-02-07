<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Admin\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function store($id) {
        
        $product = Product::find($id);

        if (!$product) {

            return Response::json(['error' => 'Product Not Found']);	 
        }

        Cart::add($product, 1, ['image_one' => $product->image_one]);

        return Response::json(['success' => 'Product Added To Your Cart']);
    }
}
