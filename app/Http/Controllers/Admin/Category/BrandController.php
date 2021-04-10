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
        return view('admin.categories.brands', ['brands' => Brand::all()]);
    }

    public function store(Request $request) {
     
        $validatedData = $request->validate([
            'brand_name' => 'required|unique:brands|max:50',
            'brand_logo' => 'image|max:4096',
        ]);

        if($request->brand_logo) {        
            $validatedData['brand_logo'] = $request->file('brand_logo')->store('media/brands', 'public');
        }

        Brand::create($validatedData);

        return redirect()->back()->with(toastNotification('Brand', 'added'));
    }

    public function edit(Brand $brand) {
        return view('admin.categories.brands_edit', compact('brand'));
    }

    public function update(Brand $brand, Request $request) {

        $validatedData = $request->validate([
            'brand_name' => ['required', 'max:50', Rule::unique('brands')->ignore($brand->id)],
            'brand_logo' => ['image', 'max:4096'],   
        ]);

        if($request->brand_logo) {

            $old_logo = $brand->getOriginal('brand_logo');

            if ($old_logo) {
                Storage::disk('public')->delete($old_logo);
            }

            $validatedData['brand_logo'] = $request->file('brand_logo')->store('media/brands', 'public');
        }

        $brand->update($validatedData);

        return redirect()->route('admin.brands.index')->with(toastNotification('Brand', 'updated'));
    }

    public function destroy(Brand $brand) {

        Storage::disk('public')->delete($brand->getOriginal('brand_logo'));
        $brand->delete();
        return redirect()->back()->with(toastNotification('Brand', 'deleted'));
    }
}