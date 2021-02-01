<?php

namespace App\Http\Controllers\Admin\Category;

use App\Model\Admin\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\ParentController;

class BrandController extends ParentController
{
    
    public function index() {
     
        return (new ParentController([Brand::all()], ["brands"], 'admin.categories.brands'))->index();
    }

    public function store(Request $request) {
     
        $data = [[
            'brand_name' => 'required|unique:brands|max:255',
            'brand_logo' => 'image|max:4096',
        ]];

        return (new ParentController([Brand::class], "Brand", '', $data))->store($request);
    }

    public function edit($id) {

        return (new ParentController([Brand::find($id)], ["brand"], 'admin.categories.brands_edit'))->edit($id);
    }

    public function update(Request $request, $id) {

        $data = [[
            'brand_name' => ['required', 'max:255', Rule::unique('brands')->ignore($id)],
            'brand_logo' => ['image', 'max:4096'],
        ]];

        return (new ParentController([Brand::class], "Brand", 'admin.brands.index', $data))->update($request, $id);
    }

    public function destroy($id) {

        return (new ParentController([Brand::class], "Brand"))->destroy($id);
    }

}
