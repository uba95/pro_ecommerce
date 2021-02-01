<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Admin\ParentController;
use Illuminate\Http\Request;
use App\Model\Admin\Category;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CategoryController extends ParentController
{
    
    public function index() {
     
        return (new ParentController([Category::all()], ["categories"], 'admin.categories.index'))->index();
    }

    public function show(Request $request, Category $category) {
     
        return $request->expectsJson() ? response()->json($category->subcategories) 
        : redirect()->route('admin.categories.index');
    }

    public function store(Request $request) {
     
        $data = [[
            'category_name' => 'required|unique:categories|max:255',
        ]];

        return (new ParentController([Category::class], "Category", '', $data))->store($request);
    }

    public function edit($id) {

        return (new ParentController([Category::find($id)], ["category"], 'admin.categories.edit'))->edit($id);
    }

    public function update(Request $request, $id) {

        $data = [[
            'category_name' => ['required', 'max:255', Rule::unique('categories')->ignore($id)]
        ]];

        return (new ParentController([Category::class], "Category", 'admin.categories.index', $data))->update($request, $id);
    }
    
    public function destroy($id) {

        return (new ParentController([Category::class], "Category"))->destroy($id);
    }
}
