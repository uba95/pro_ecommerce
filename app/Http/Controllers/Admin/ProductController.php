<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Brand;
use App\Model\Admin\Product;
use Illuminate\Http\Request;
use App\Model\Admin\Category;
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

    public function show($id) {

        $product = Product::find($id);

        return $product ? view('admin.products.show', compact('product')) 
        : redirect()->back()->with(toastNotification('Product', 'not_found'));
    }

    public function create() {

        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
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

    public function edit($id) {

        $product = Product::find($id);
        $categories = Category::all();
        $brands = Brand::all();

        return $product ? view('admin.products.edit', compact('product', 'categories', 'brands')) 
        : redirect()->back()->with(toastNotification('Product', 'not_found'));
    }

    public function changeStatus($id) {
     
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with(toastNotification('Product', 'not_found'));
        }

        $product->update(['status' => !$product->status]);

        return redirect()->back()->with(toastNotification('Product Status Changed Successfully'));     
    }

    public function update($id, ProductRequest $request) {

        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('admin.products.index')->with(toastNotification('Product', 'not_found'));
        }

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

    public function destroy($id) {

        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with(toastNotification('Product', 'not_found'));
        }

        Storage::disk('public')->delete([$product->getOriginal('image_one'),$product->getOriginal('image_two'),$product->getOriginal('image_three')]);
        $product->delete();

        return redirect()->back()->with(toastNotification('Product', 'deleted'));

    }

}
