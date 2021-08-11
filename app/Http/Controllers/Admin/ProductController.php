<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
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
        $attributes['product_size'] = json_encode($request->product_size);
        $attributes['product_color'] = json_encode($request->product_color);
    
        $image_one = $request->image_one;
        $image_two = $request->image_two;
        $image_three = $request->image_three;

        if ($image_one && $image_two && $image_three) {
            
            $attributes['image_one'] = 'media/products/' . img_upload($image_one);
            $attributes['image_two'] = 'media/products/' . img_upload($image_two);
            $attributes['image_three'] = 'media/products/' . img_upload($image_three);
        }

        Product::create($attributes);

        return redirect()->back()->with(toastNotification('Product', 'added'));

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
        $attributes['product_size'] = json_encode($request->product_size);
        $attributes['product_color'] = json_encode($request->product_color);
        $attributes['main_slider'] = $request->main_slider;
        $attributes['hot_deal'] = $request->hot_deal;
        $attributes['best_rated'] = $request->best_rated;
        $attributes['trend'] = $request->trend;
        $attributes['mid_slider'] = $request->mid_slider;
        $attributes['hot_new'] = $request->hot_new;

        $image_one = $request->image_one;
        $image_two = $request->image_two;
        $image_three = $request->image_three;

        if ($image_one && $image_two && $image_three) {

            $old_img1 = $product->getAttributes()['image_one'];
            $old_img2 = $product->getAttributes()['image_two'];
            $old_img3 = $product->getAttributes()['image_three'];

            if ($old_img1 && $old_img2 && $old_img3) {
                Storage::disk('public')->delete($old_img1, $old_img2, $old_img3);
            }

            $attributes['image_one'] = 'media/products/' . img_upload($image_one);
            $attributes['image_two'] = 'media/products/' . img_upload($image_two);
            $attributes['image_three'] = 'media/products/' . img_upload($image_three);
        }

        $product->update($attributes);

        return redirect()->route('admin.products.index')->with(toastNotification('Product', 'updated'));

    }

    public function destroy(Product $product) {

        Storage::disk('public')->delete([$product->getOriginal('image_one'),$product->getOriginal('image_two'),$product->getOriginal('image_three')]);
        $product->delete();

        return redirect()->back()->with(toastNotification('Product', 'deleted'));
    }
}
