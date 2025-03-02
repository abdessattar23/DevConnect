<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('user')
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);

        if ($request->ajax()) {
            $view = view('posts._post_list', compact('posts'))->render();
            return response()->json([
                'html' => $view,
                'nextPage' => $posts->hasMorePages() ? $request->url() . '?page=' . $posts->currentPage() + 1 : null
            ]);
        }

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'code_snippet' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $validated['content'];
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images', 'public');
            $post->image_url = $imagePath;
        }
        
        if ($request->filled('code_snippet')) {
            $post->code_snippet = $validated['code_snippet'];
        }
        
        $post->save();

        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        if (Auth::id() !== $post->user_id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'image_url' => 'nullable|url',
            'code_snippet' => 'nullable|string',
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post)
                         ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        $post->delete();

        return redirect()->route('posts.index')
                         ->with('success', 'Post deleted successfully!');
    }
}