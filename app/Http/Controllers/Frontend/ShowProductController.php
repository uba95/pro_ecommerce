<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowProductController extends Controller
{
    public function __invoke(Product $product) {
        
        // $categories = DB::table('categories')->get();
        // $subcategories = DB::table('subcategories')->get();
        return view('pages.product', compact('product'));
    }
}
