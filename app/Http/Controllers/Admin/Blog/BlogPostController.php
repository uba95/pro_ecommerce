<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostRequest;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    public function index() {
        return view('admin.blog.posts', ['posts' => BlogPost::with('category')->get()]);
    }

    public function create() {
        return view('admin.blog.post_create', ['categories' => BlogCategory::orderBy('id')->pluck('blog_category_name', 'id')]);
    }

    public function store(BlogPostRequest $request) {
     
        $validatedData = $request->validated();

        if($request->post_image) {
            
            $validatedData['post_image'] = $request->file('post_image')->store('media/blog', 'public');
        }

        BlogPost::create($validatedData);

        return redirect()->back()->with(toastNotification('Blog Post', 'added'));
    }

    public function edit(BlogPost $blogPost) {
        $categories = BlogCategory::orderBy('id')->pluck('blog_category_name', 'id');
        return view('admin.blog.posts_edit', compact('blogPost', 'categories'));
    }

    public function update(BlogPost $blogPost, BlogPostRequest $request) {

        $validatedData = $request->validated();

        if($request->post_image) {

            $old_logo = $blogPost->getAttributes()['post_image'];

            if ($old_logo) {
                Storage::disk('public')->delete($old_logo);
            }

            $validatedData['post_image'] = $request->file('post_image')->store('media/blog', 'public');
        }

        $blogPost->update($validatedData);

        return redirect()->route('admin.blog_posts.index')->with(toastNotification('Blog Post', 'updated'));
    }

    public function destroy(BlogPost $blogPost) {

        Storage::disk('public')->delete($blogPost->getAttributes()['post_image']);
        $blogPost->delete();
        
        return redirect()->back()->with(toastNotification('Blog Post', 'deleted'));
    }
}
