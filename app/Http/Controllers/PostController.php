<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Hashtags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    
    public function index()
    {
        $posts = Posts::with(['user', 'hashtags', 'likes', 'comments'])->latest()->get();
        return view('dashboard', compact('posts')); 
    }

    
    public function create()
    {
    $hashtags = Hashtags::all();
       return view('profile.post.add', compact('hashtags')); 
    }

    
  
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'hashtags' => 'array',
            'new_hashtags' => 'nullable|string'
        ]);

        $post = new Posts();
        $post->user_id = Auth::id();
        $post->title = $request->input('title', ''); // Set empty string as default
        $post->content = $request->input('content');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        if ($request->filled('new_hashtags')) {
            $newHashtags = explode(',', $request->input('new_hashtags'));
            $hashtagIds = [];
            foreach ($newHashtags as $newHashtag) {
                $newHashtag = trim($newHashtag);
                if (!empty($newHashtag)) {
                    $hashtag = Hashtags::firstOrCreate(['name' => $newHashtag]);
                    $hashtagIds[] = $hashtag->id;
                }
            }
            if (!empty($hashtagIds)) {
                $post->hashtags()->sync($hashtagIds);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Post created successfully.');
    }

    public function show()
    {
        //
    }

    public function edit($id)
    {
        $post = Posts::findOrFail($id);
        $hashtags = Hashtags::all();
        return view('profile.post.edit',compact('post','hashtags'));
    }

   

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000'
    ]);

    $post = Posts::findOrFail($id);
    $post->title = $request->input('title');
    $post->content = $request->input('content');

    if ($request->hasFile('image')) {
        $post->image = $request->file('image')->store('images', 'public');
    }

    $post->save();

    $hashtags = $request->input('hashtags', []);

    if ($request->filled('new_hashtags')) {
        $newHashtags = explode(',', $request->input('new_hashtags'));
        foreach ($newHashtags as $newHashtag) {
            $newHashtag = trim($newHashtag);
            if (!empty($newHashtag)) {
                $hashtag = Hashtags::firstOrCreate(['name' => $newHashtag]);
                $hashtags[] = $hashtag->id;
            }
        }
    }

    $post->hashtags()->attach($hashtags);

    return redirect()->route('profile.view')->with('success', 'Post updated successfully.');
}
    
   
    public function destroy($id) {
   
        Posts::where('id', $id)->delete();
        return redirect()->route('profile.view')->with('success', 'post deleted successfully');
    }
   
    
}