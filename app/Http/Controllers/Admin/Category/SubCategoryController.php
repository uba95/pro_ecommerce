<?php

namespace App\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;
use App\Models\Subcategory;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function __construct() {
        $this->middleware('can:view categories',    ['only' => ['index']]);
        $this->middleware('can:create categories',  ['only' => ['store']]);
        $this->middleware('can:edit categories',    ['only' => ['edit', 'update']]);
        $this->middleware('can:delete categories',  ['only' => ['destroy']]);
    }

    public function index() {   
        return view('admin.categories.subcategories', [
            'categories' => Category::orderBy('id')->pluck('category_name', 'id'),
            'subcategories' => Subcategory::with('category:id,category_name')->get()
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
        return redirect()->back()->with(toastNotification('Subcategory', 'created'));
    }

    public function edit(Subcategory $subcategory) {
        $categories =  Category::orderBy('id')->pluck('category_name', 'id');
        return view('admin.categories.subcategories_edit', compact('subcategory', 'categories'));
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