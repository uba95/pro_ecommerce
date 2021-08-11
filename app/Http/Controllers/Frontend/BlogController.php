<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index() {
        return view('pages.blog.index', ['posts' => BlogPost::with('category')->get()]);
    }

    public function show(BlogPost $blog_post) {
        $posts = $blog_post->category->posts()->where('id', '<>', $blog_post->id)->inRandomOrder()->limit(3)->get();
        return view('pages.blog.show', compact('blog_post', 'posts'));
    }
    
    public function showCategory(BlogCategory $blogCategory) {
        return view('pages.blog.index', ['posts' => $blogCategory->posts]);
    }
}
