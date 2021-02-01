<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\ParentController;
use Illuminate\Http\Request;
use App\Model\Admin\Category;
use Illuminate\Validation\Rule;
use App\Model\Admin\Subcategory;
use App\Http\Controllers\Controller;

class SubCategoryController extends ParentController
{
    public function index() {
     
        return (new ParentController([Subcategory::with('category')->get(), Category::all()], ["subcategories", "categories"], 'admin.categories.subcategories'))->index();
    }

    public function store(Request $request) {
     
        $data = [[
            'subcategory_name' => 'required|unique:subcategories|max:255',
            'category_id' => 'required|numeric',
        ], 
        [
            'category_id.required' => 'The category name field is required.'
        ]];

        return (new ParentController([Subcategory::class], "Subcategory", '', $data))->store($request);
    }

    public function edit($id) {

        return (new ParentController([Subcategory::with('category')->find($id), Category::all()], ["subcategory", "categories"], 'admin.categories.subcategories_edit'))->edit($id);
    }

    public function update(Request $request, $id) {

        $data = [[
            'subcategory_name' => ['required', 'max:255', Rule::unique('subcategories')->ignore($id)],
            'category_id' => ['required', 'numeric'],
        ], 
        [
            'category_id.required' => 'The category name field is required.'
        ]];

        return (new ParentController([Subcategory::class], "Subcategory", 'admin.subcategories.index', $data))->update($request, $id);
    }

    public function destroy($id) {

        return (new ParentController([Subcategory::class], "Subcategory"))->destroy($id);
    }

}
