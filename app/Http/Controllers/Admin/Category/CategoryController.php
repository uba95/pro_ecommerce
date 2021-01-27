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

    public function show(Request $request, Category $category) {
     
        return $request->expectsJson() ? response()->json($category->subcategories) : redirect()->route('admin.categories.index');
    }

    public function store(Request $request) {
     
        $validatedData = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ]);
    
        Category::create($validatedData);

        return redirect()->back()->with(toastNotification('Category', 'added'));

    }

    public function edit($id) {

        $category = Category::find($id);

        if (!$category) {

            return redirect()->back()->with(toastNotification('Category', 'not_found'));
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update($id, Request $request) {

        $category = Category::find($id);

        if (!$category) {

            return redirect()->route('admin.categories.index')->with(toastNotification('Category', 'not_found'));
        }

        $validatedData = $request->validate([
            'category_name' => ['required', 'max:255', Rule::unique('categories')->ignore($category->id)],
        ]);

        $category->update($validatedData);

        return redirect()->route('admin.categories.index')->with(toastNotification('Category', 'updated'));

    }
    
    public function destroy($id) {

        $category = Category::find($id);

        if (!$category) {
            return redirect()->back()->with(toastNotification('Category', 'not_found'));
        }

        $category->delete();

        return redirect()->back()->with(toastNotification('Category', 'deleted'));

    }
}
