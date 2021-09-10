<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotDealRequest;
use App\Models\HotDealProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HotDealProductController extends Controller
{
    public function index() {
        return view('admin.products.hot-deals.index', ['deals' => HotDealProduct::with('product')->get()]);
    }

    public function create(Product $product) {
        return view('admin.products.hot-deals.create', compact('product'));
    }

    public function store(HotDealRequest $request, Product $product) {

        $validated = $request->validated();
        // $validated['status'] = $validated['expired_at'] < now() ?  'expired' : $validated['status'];

        $product->hotDeal()->create(Arr::except($validated, 'discount_price'));
        $product->update(Arr::only($validated, 'discount_price'));

        return redirect()->route('admin.products.hot_deals.index')->with(toastNotification('Hot Deal', 'created'));
    }

    public function edit(Product $product) {
        return view('admin.products.hot-deals.edit', ['deal' => HotDealProduct::where('product_id', $product->id)->firstOrFail()]);
    }

    public function update(HotDealRequest $request, Product $product) {
        
        $deal = HotDealProduct::where('product_id', $product->id)->firstOrFail();

        $validated = $request->validated();
        // $validated['status'] = $validated['expired_at'] < now() ?  'expired' : $validated['status'];

        $deal->update(Arr::except($validated, 'discount_price'));
        $product->update(Arr::only($validated, 'discount_price'));

        return redirect()->route('admin.products.hot_deals.index')->with(toastNotification('Hot Deal', 'updated'));
    }

    public function destroy(Product $product) {

        HotDealProduct::where('product_id', $product->id)->firstOrFail()->delete();
        return redirect()->route('admin.products.hot_deals.index')->with(toastNotification('Hot Deal', 'deleted'));
    }

}
