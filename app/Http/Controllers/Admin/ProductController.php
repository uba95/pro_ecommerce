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
use App\Models\ProductMeta;
use App\Services\AjaxDatatablesService;
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
        $products = Product::with('category:id,category_name', 'subcategory:id,subcategory_name','brand:id,brand_name')->select('products.*');
        return request()->expectsJson() ? AjaxDatatablesService::products($products) : view('admin.products.index');
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
    
        if ($request->hasFile('cover')) {
            $attributes['cover'] = img_upload($request->file('cover'), Product::COVERS_STOREAGE, true);
        }

        $meta = ['meta_title', 'meta_keywords', 'meta_description'];
        
        $product = Product::create(Arr::except($attributes, ['image', ...$meta]));

        if ($request->hasFile('image')) {

            $data = ['product_id' => $product->id, 'created_at' => now(), 'updated_at' => now()];
            $imgs = array_map(fn($v) => img_upload($v, Product::IMAGES_STOREAGE), $request->file('image'));
            
            DB::table('product_images')->insert(
                array_map(fn($img) => ['name' => $img] + $data , $imgs)    
            );
        }

        if ($request->hasAny($meta)) {

            $product->meta()->create(Arr::only($attributes, $meta));
        }

        return redirect()->back()->with(toastNotification('Product', 'created'));

    }

    public function edit(Product $product) {
        $categories = Category::orderBy('id')->pluck('category_name', 'id');
        $brands = Brand::orderBy('id')->pluck('brand_name', 'id');
        return view('admin.products.edit', compact('product', 'categories', 'brands')); 
    }

    public function changeStatus(Product $product) {
        $product->update(['status' => (int) !$product->status->getIndex()]);
        return redirect()->back()->with(toastNotification('Product Status Changed Successfully'));     
    }

    public function update(Product $product, ProductRequest $request) {

        $attributes = $request->validated();

        if ($request->hasFile('cover')) {

            Storage::disk('public')->delete($product->getOriginal('cover'));
            $attributes['cover'] = img_upload($request->file('cover'), Product::COVERS_STOREAGE, true);
        }
        
        $meta = ['meta_title', 'meta_keywords', 'meta_description'];

        $product->update(Arr::except($attributes, ['image', ...$meta]));
        
        if ($request->hasFile('image')) {

            $data = ['product_id' => $product->id, 'created_at' => now(), 'updated_at' => now()];
            $imgs = array_map(fn($v) => img_upload($v, Product::IMAGES_STOREAGE), $request->file('image'));

            DB::table('product_images')->insert(
                array_map(fn($img) => ['name' => $img] + $data , $imgs)    
            );
        }
        
        if ($request->hasAny($meta)) {

            $product->meta()->updateOrCreate(['product_id' => $product->id], Arr::only($attributes, $meta));
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
