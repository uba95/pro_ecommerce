<?php

namespace App\Http\Controllers\Admin\Category;

use App\Model\Admin\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    
    public function index() {
     
        $brands = Brand::all();
        return view('admin.categories.brands', compact('brands'));
    }

    public function store(Request $request) {
     
        $validatedData = $request->validate([
            'brand_name' => 'required|unique:brands|max:255',
            'brand_logo' => 'image|max:4096',
        ]);

        if($request->brand_logo) {
            
            $validatedData['brand_logo'] = $request->file('brand_logo')->store('media/brands', 'public');
        }

        Brand::create($validatedData);

        return redirect()->back()->with(toastNotification('Brand', 'added'));


    }

    public function edit($id) {

        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->back()->with(toastNotification('Brand', 'not_found'));
        }

        return view('admin.categories.brands_edit', compact('brand'));
    }

    public function update($id, Request $request) {

        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->route('admin.brands.index')->with(toastNotification('Brand', 'not_found'));
        }

        $validatedData = $request->validate([
            'brand_name' => ['required', 'max:255', Rule::unique('brands')->ignore($brand->id)],
            'brand_logo' => ['image', 'max:4096'],
            
        ]);

        if($request->brand_logo) {

            $old_logo = $brand->getAttributes()['brand_logo'];

            if ($old_logo) {
                Storage::disk('public')->delete($old_logo);
            }

            $validatedData['brand_logo'] = $request->file('brand_logo')->store('media/brands', 'public');
        }

        $brand->update($validatedData);

        return redirect()->route('admin.brands.index')->with(toastNotification('Brand', 'updated'));

    }

    public function destroy($id) {

        $brand = Brand::find($id);

        if (!$brand) {
            $notification=array(
                'messege'=>'Brand Not Found',
                'alert-type'=>'error'
            );

            return redirect()->back()->with(toastNotification('Brand', 'not_found'));
        }
        // Storage::disk('public')->delete($brand->getOriginal('brand_logo'));
        Storage::disk('public')->delete($brand->getAttributes()['brand_logo']);
        $brand->delete();
        
        return redirect()->back()->with(toastNotification('Brand', 'deleted'));

    }

}
