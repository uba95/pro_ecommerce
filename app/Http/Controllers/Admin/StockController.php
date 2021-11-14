<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\AjaxDatatablesService;

class StockController extends Controller
{
    public function __construct() {
        $this->middleware('can:view reports');
    }

    public function __invoke(Request $request) {
        return  request()->expectsJson() 
                ? AjaxDatatablesService::stocks(
                    Product::select(['id','product_name','product_quantity'])
                    ->when($request->status, fn($q) => $q->StockStatusQuantity($request->status))
                )
                : view('admin.products.stocks');
    }
}
