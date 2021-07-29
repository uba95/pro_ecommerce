<?php

namespace App\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;
use App\Models\Subcategory;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index() {   
        return view('admin.categories.subcategories', [
            'categories' => Category::all(),
            'subcategories' => Subcategory::with('category')->get()
        ]);
    }

    public function store(Request $request) {
     
        $validatedData = $request->validate([
            'subcategory_name' => 'required|unique:subcategories|max:50',
            'category_id' => 'required|numeric',
        ], 
        [
            'category_id.required' => 'The category name field is required.'
        ]);
    
        Subcategory::create($validatedData);
        return redirect()->back()->with(toastNotification('Subcategory', 'added'));
    }

    public function edit(Subcategory $subcategory) {
        return view('admin.categories.subcategories_edit', compact('subcategory') + ['categories' => Category::all()]);
    }

    public function update(Subcategory $subcategory, Request $request) {

        $validatedData = $request->validate([
            'subcategory_name' => ['required', 'max:50', Rule::unique('subcategories')->ignore($subcategory->id)],
            'category_id' => ['required', 'numeric'],
        ], 
        [
            'category_id.required' => 'The category name field is required.'
        ]);

        $subcategory->update($validatedData);
        return redirect()->route('admin.subcategories.index')->with(toastNotification('Category', 'updated'));
    }

    public function destroy(Subcategory $subcategory) {
        $subcategory->delete();
        return redirect()->back()->with(toastNotification('Subcategory', 'deleted'));
    }
}