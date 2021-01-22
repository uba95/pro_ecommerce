<?php

namespace App\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use App\Model\Admin\Category;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    
    public function index() {
     
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request) {
     
        $validatedData = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ]);
    
        Category::create($validatedData);

        $notification=array(
            'messege'=>'New Category Added Successfully',
            'alert-type'=>'success'
        );

        return redirect()->back()->with($notification);

    }

    public function edit($id) {

        $category = Category::find($id);

        if (!$category) {
            $notification=array(
                'messege'=>'Category Not Found',
                'alert-type'=>'error'
            );
            
            return redirect()->back()->with($notification);
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update($id, Request $request) {

        $category = Category::find($id);

        if (!$category) {
            $notification=array(
                'messege'=>'Category Not Found',
                'alert-type'=>'error'
            );

            return redirect()->route('admin.categories.index')->with($notification);
        }

        $validatedData = $request->validate([
            'category_name' => ['required', 'max:255', Rule::unique('categories')->ignore($category->id)],
        ]);

        $category->update($validatedData);

        $notification=array(
            'messege'=>'Category Updated Successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('admin.categories.index')->with($notification);

    }
    
    public function destroy($id) {

        $category = Category::find($id);

        if (!$category) {
            $notification=array(
                'messege'=>'Category Not Found',
                'alert-type'=>'error'
            );

            return redirect()->back()->with($notification);
        }

        $category->delete();

        $notification=array(
            'messege'=>'Category Deleted Successfully',
            'alert-type'=>'success'
        );

        return redirect()->back()->with($notification);

    }
}
