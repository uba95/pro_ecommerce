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

        $notification=array(
            'messege'=>'New Subcategory Added Successfully',
            'alert-type'=>'success'
        );

        return redirect()->back()->with($notification);

    }

    public function edit($id) {

        $categories = Category::all();
        $subcategory = Subcategory::with('category')->find($id);

        if (!$subcategory) {
            $notification=array(
                'messege'=>'Subcategory Not Found',
                'alert-type'=>'error'
            );
            
            return redirect()->back()->with($notification);
        }

        return view('admin.categories.subcategories_edit', compact('categories', 'subcategory'));
    }

    public function update($id, Request $request) {

        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            $notification=array(
                'messege'=>'Subcategory Not Found',
                'alert-type'=>'error'
            );

            return redirect()->route('admin.subcategories.index')->with($notification);
        }

        $validatedData = $request->validate([
            'subcategory_name' => ['required', 'max:255', Rule::unique('subcategories')->ignore($subcategory->id)],
            'category_id' => ['required', 'numeric'],
        ], 
        [
            'category_id.required' => 'The category name field is required.'
        ]);

        $subcategory->update($validatedData);

        $notification=array(
            'messege'=>'Subcategory Updated Successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('admin.subcategories.index')->with($notification);

    }

    public function destroy($id) {

        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            $notification=array(
                'messege'=>'Subcategory Not Found',
                'alert-type'=>'error'
            );

            return redirect()->back()->with($notification);
        }

        $subcategory->delete();

        $notification=array(
            'messege'=>'Subcategory Deleted Successfully',
            'alert-type'=>'success'
        );

        return redirect()->back()->with($notification);

    }

}
