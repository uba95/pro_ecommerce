<?php

namespace App\Http\Controllers\Admin\Blog;

use Illuminate\Http\Request;
use App\Model\Admin\Blog\BlogPost;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostRequest;
use App\Model\Admin\Blog\BlogCategory;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    public function index() {
     
        $posts = BlogPost::with('category')->get();
        return view('admin.blog.posts', compact('posts'));
    }

    public function create() {

        $categories = BlogCategory::all();
        
        return view('admin.blog.post_create', compact('categories'));
    }

    public function store(BlogPostRequest $request) {
     
        $validatedData = $request->validated();

        if($request->post_image) {
            
            $validatedData['post_image'] = $request->file('post_image')->store('media/blog', 'public');
        }

        BlogPost::create($validatedData);

        return redirect()->back()->with(toastNotification('Blog Post', 'added'));

    }

    public function edit($id) {

        $post = BlogPost::find($id);
        $categories = BlogCategory::all();

        if (!$post) {
            return redirect()->back()->with(toastNotification('Blog Post', 'not_found'));
        }

        return view('admin.blog.posts_edit', compact('post', 'categories'));
    }

    public function update($id, BlogPostRequest $request) {

        $post = BlogPost::find($id);

        if (!$post) {
            return redirect()->route('admin.blog_posts.index')->with(toastNotification('Blog Post', 'not_found'));
        }

        $validatedData = $request->validated();

        if($request->post_image) {

            $old_logo = $post->getAttributes()['post_image'];

            if ($old_logo) {
                Storage::disk('public')->delete($old_logo);
            }

            $validatedData['post_image'] = $request->file('post_image')->store('media/blog', 'public');
        }

        $post->update($validatedData);

        return redirect()->route('admin.blog_posts.index')->with(toastNotification('Blog Post', 'updated'));

    }

    public function destroy($id) {

        $post = BlogPost::find($id);

        if (!$post) {
            return redirect()->back()->with(toastNotification('Blog Post', 'not_found'));
        }

        Storage::disk('public')->delete($post->getAttributes()['post_image']);
        $post->delete();
        
        return redirect()->back()->with(toastNotification('Blog Post', 'deleted'));

    }

}
