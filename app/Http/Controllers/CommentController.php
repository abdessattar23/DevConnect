<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Policies\CommentPolicy;

class CommentController extends Controller
{
    /**
     * Display all comments for a post.
     */
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user', 'replies.user')->latest()->get();
        
        return view('comments.index', compact('post', 'comments'));
    }
    
    /**
     * Store a new comment.
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        
        $comment = $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'parent_id' => $validated['parent_id'] ?? null,
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'comment' => $comment->load('user'),
            ]);
        }
        
        return redirect()->back()->with('success', 'Comment added successfully!');
    }
    
    /**
     * Store a reply to an existing comment.
     */
    public function reply(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);
        
        $reply = $comment->post->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'parent_id' => $comment->id,
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'reply' => $reply->load('user'),
            ]);
        }
        
        return redirect()->back()->with('success', 'Reply added successfully!');
    }
    
    /**
     * Update a comment.
     */
    public function update(Request $request, Comment $comment)
    {
        // Check if user is authorized to update
        $this->authorize('update', $comment);
        
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);
        
        $comment->update([
            'content' => $request->content
        ]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'comment' => $comment->fresh()
            ]);
        }
        
        return back()->with('success', 'Comment updated successfully.');
    }
    
    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment)
    {
        // Check if user is authorized to delete
        $this->authorize('delete', $comment);
        
        $post = $comment->post;
        $comment->delete();
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'commentsCount' => $post->fresh()->getCommentCountAttribute()
            ]);
        }
        
        return back()->with('success', 'Comment deleted successfully.');
    }
}
