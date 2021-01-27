<?php

namespace App\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use App\Model\Admin\Category;
use Illuminate\Validation\Rule;
use App\Model\Admin\Subcategory;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index() {
     
        $categories = Category::all();
        $subcategories = Subcategory::with('category')->get();
        return view('admin.categories.subcategories', compact('categories', 'subcategories'));
    }

    public function store(Request $request) {
     
        $validatedData = $request->validate([
            'subcategory_name' => 'required|unique:subcategories|max:255',
            'category_id' => 'required|numeric',
        ], 
        [
            'category_id.required' => 'The category name field is required.'
        ]);
    
        Subcategory::create($validatedData);

        return redirect()->back()->with(toastNotification('Subcategory', 'added'));

    }

    public function edit($id) {

        $categories = Category::all();
        $subcategory = Subcategory::with('category')->find($id);

        if (!$subcategory) {
            return redirect()->back()->with(toastNotification('Subcategory', 'not_found'));
        }

        return view('admin.categories.subcategories_edit', compact('categories', 'subcategory'));
    }

    public function update($id, Request $request) {

        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            return redirect()->route('admin.subcategories.index')->with(toastNotification('Subcategory', 'not_found'));
        }

        $validatedData = $request->validate([
            'subcategory_name' => ['required', 'max:255', Rule::unique('subcategories')->ignore($subcategory->id)],
            'category_id' => ['required', 'numeric'],
        ], 
        [
            'category_id.required' => 'The category name field is required.'
        ]);

        $subcategory->update($validatedData);

        return redirect()->route('admin.subcategories.index')->with(toastNotification('Category', 'updated'));


    }

    public function destroy($id) {

        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            return redirect()->back()->with(toastNotification('Subcategory', 'not_found'));
        }

        $subcategory->delete();

        $notification=array(
            'messege'=>'Subcategory Deleted Successfully',
            'alert-type'=>'success'
        );

        return redirect()->back()->with(toastNotification('Subcategory', 'deleted'));

    }

}
