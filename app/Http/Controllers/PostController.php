<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }



    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        foreach ($post->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                PostImage::create([
                    'post_id' => $post->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }




    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
