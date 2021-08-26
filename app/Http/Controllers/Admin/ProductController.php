<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\ProductImage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('can:view products',    ['only' => ['index', 'show']]);
        $this->middleware('can:create products',  ['only' => ['create', 'store']]);
        $this->middleware('can:edit products',    ['only' => ['edit', 'update', 'changeStatus', 'destroyImage']]);
        $this->middleware('can:delete products',  ['only' => ['destroy']]);
    }

    public function index() {
        $products = Product::with('category:id,category_name', 'subcategory:id,subcategory_name','brand:id,brand_name')->get();
        return view('admin.products.index', compact('products'));
    }

    public function show(Product $product) {
        return view('admin.products.show', compact('product')); 
    }

    public function create() {
        return view('admin.products.create', [
            'categories' => Category::orderBy('id')->pluck('category_name', 'id'),
            'brands' => Brand::orderBy('id')->pluck('brand_name', 'id')
        ]);
    }

    public function store(ProductRequest $request) {

        $attributes = $request->validated();

        $attributes['status'] = 1;
        $attributes['product_slug'] = Str::slug($request->product_name);
    
        if ($request->hasFile('cover')) {
            $attributes['cover'] = img_upload($request->file('cover'), 'media/products/covers/', true);
        }

        $product = Product::create(Arr::except($attributes, 'image'));

        if ($request->hasFile('image')) {

            $data = ['product_id' => $product->id, 'created_at' => now(), 'updated_at' => now()];
            $imgs = array_map(fn($v) => img_upload($v), $request->file('image'));
            
            DB::table('product_images')->insert(
                array_map(fn($img) => ['name' => $img] + $data , $imgs)    
            );
        }

        return redirect()->back()->with(toastNotification('Product', 'created'));

    }

    public function edit(Product $product) {
        $categories = Category::orderBy('id')->pluck('category_name', 'id');
        $brands = Brand::orderBy('id')->pluck('brand_name', 'id');
        return view('admin.products.edit', compact('product', 'categories', 'brands')); 
    }

    public function changeStatus(Product $product) {
        $product->update(['status' => !$product->status]);
        return redirect()->back()->with(toastNotification('Product Status Changed Successfully'));     
    }

    public function update(Product $product, ProductRequest $request) {

        $attributes = $request->validated();
        $attributes['product_slug'] = Str::slug($request->product_name);
        $attributes['main_slider'] = $request->main_slider;
        $attributes['hot_deal'] = $request->hot_deal;
        $attributes['best_rated'] = $request->best_rated;
        $attributes['trend'] = $request->trend;
        $attributes['mid_slider'] = $request->mid_slider;
        $attributes['hot_new'] = $request->hot_new;

        if ($request->hasFile('cover')) {

            Storage::disk('public')->delete($product->getOriginal('cover'));
            $attributes['cover'] = img_upload($request->file('cover'), 'media/products/covers/', true);
        }

        $product->update(Arr::except($attributes, 'image'));
        
        if ($request->hasFile('image')) {

            $data = ['product_id' => $product->id, 'created_at' => now(), 'updated_at' => now()];
            $imgs = array_map(fn($v) => img_upload($v), $request->file('image'));

            DB::table('product_images')->insert(
                array_map(fn($img) => ['name' => $img] + $data , $imgs)    
            );
        }

        return redirect()->route('admin.products.index')->with(toastNotification('Product', 'updated'));
    }

    public function destroyImage(ProductImage $productImage) {

        Storage::disk('public')->delete($productImage->getOriginal('name'));
        $productImage->delete();

        return redirect()->back()->with(toastNotification('Product Image', 'deleted'));
    }

    public function destroy(Product $product) {

        Storage::disk('public')->delete($product->getOriginal('cover'));
        Storage::disk('public')->delete($product->images->map(fn($img) => $img->getOriginal('name'))->toArray());
        
        $product->delete();

        return redirect()->back()->with(toastNotification('Product', 'deleted'));
    }
}
