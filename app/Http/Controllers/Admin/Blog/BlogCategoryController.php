<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    public function index() {
        return view('admin.blog.categories', ['categories' => BlogCategory::all()]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate(['blog_category_name' => 'required|unique:blog_categories|max:255']);
        BlogCategory::create($validatedData);
        return redirect()->back()->with(toastNotification('Blog Category', 'added'));
    }

    public function edit(BlogCategory $blogCategory) {
        return view('admin.blog.categories_edit', compact('blogCategory'));
    }

    public function update(BlogCategory $blogCategory, Request $request) {
        $validatedData = $request->validate([
            'blog_category_name' => ['required', 'max:255', Rule::unique('blog_categories')->ignore($blogCategory->id)],
        ]);
        $blogCategory->update($validatedData);
        return redirect()->route('admin.blog_categories.index')->with(toastNotification('Blog Category', 'updated'));
    }

    public function destroy(BlogCategory $BlogCategory) {
        $BlogCategory->delete();
        return redirect()->back()->with(toastNotification('Blog Category', 'deleted'));
    }
}
