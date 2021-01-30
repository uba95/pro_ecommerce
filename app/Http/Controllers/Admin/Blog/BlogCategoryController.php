<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Model\Admin\Blog\BlogCategory;

class BlogCategoryController extends Controller
{
    public function index() {
     
        $categories = BlogCategory::all();
        return view('admin.blog.categories', compact('categories'));
    }

    public function store(Request $request) {
     
        $validatedData = $request->validate([
            'category_name' => 'required|unique:blog_categories|max:255',
        ]);
    
        BlogCategory::create($validatedData);

        return redirect()->back()->with(toastNotification('Blog Category', 'added'));
    }

    public function edit($id) {

        $category = BlogCategory::find($id);

        if (!$category) {

            return redirect()->back()->with(toastNotification('Blog Category', 'not_found'));
        }

        return view('admin.blog.categories_edit', compact('category'));
    }

    public function update($id, Request $request) {

        $category = BlogCategory::find($id);

        if (!$category) {
            return redirect()->route('admin.blog_categories.index')->with(toastNotification('Blog Category', 'not_found'));
        }

        $validatedData = $request->validate([
            'category_name' => ['required', 'max:255', Rule::unique('blog_categories')->ignore($category->id)],
        ]);

        $category->update($validatedData);

        return redirect()->route('admin.blog_categories.index')->with(toastNotification('Blog Category', 'updated'));

    }

    public function destroy($id) {

        $category = BlogCategory::find($id);

        if (!$category) {
            return redirect()->back()->with(toastNotification('Blog Category', 'not_found'));
        }

        $category->delete();

        return redirect()->back()->with(toastNotification('Blog Category', 'deleted'));

    }

}
