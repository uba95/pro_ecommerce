<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class StockController extends Controller
{
    public function __invoke(Request $request) {
        $products = Product::get(['id', 'product_name', 'product_quantity']);
        $products = $request->status ?  $products->filter(fn($product) => $product->stockStatus == $request->status) : $products;
        return view('admin.products.stocks', compact('products'));    
    }
}
