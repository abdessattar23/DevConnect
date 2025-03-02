<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Like or unlike a post.
     */
    public function toggleLike(Post $post)
    {
        $user = Auth::user();
        
        // Check if user already liked the post
        $existingLike = Like::where('user_id', $user->id)
                           ->where('post_id', $post->id)
                           ->whereNull('comment_id')
                           ->first();
                           
        if ($existingLike) {
            // Unlike - delete the like
            $existingLike->delete();
            $liked = false;
        } else {
            // Like - create a new like
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'comment_id' => null
            ]);
            $liked = true;
        }
        
        // Return JSON response for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'liked' => $liked,
                'likeCount' => $post->fresh()->likes()->count()
            ]);
        }
        
        // Return redirect for non-AJAX requests
        return back();
    }
    
    /**
     * Like or unlike a comment.
     */
    public function toggleCommentLike(Comment $comment)
    {
        $user = Auth::user();
        
        // Check if user already liked the comment
        $existingLike = Like::where('user_id', $user->id)
                           ->where('comment_id', $comment->id)
                           ->first();
                           
        if ($existingLike) {
            // Unlike - delete the like
            $existingLike->delete();
            $liked = false;
        } else {
            // Like - create a new like
            Like::create([
                'user_id' => $user->id,
                'post_id' => $comment->post_id,
                'comment_id' => $comment->id
            ]);
            $liked = true;
        }
        
        // Return JSON response for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'liked' => $liked,
                'likeCount' => $comment->fresh()->likes()->count()
            ]);
        }
        
        // Return redirect for non-AJAX requests
        return back();
    }
    
    /**
     * Get users who liked a post.
     */
    public function getLikers(Post $post)
    {
        $likers = $post->likes()->with('user')->get()->pluck('user');
        
        return view('likes.likers', compact('post', 'likers'));
    }
    
    /**
     * Get users who liked a comment.
     */
    public function getCommentLikers(Comment $comment)
    {
        $likers = $comment->likes()->with('user')->get()->pluck('user');
        
        return view('likes.comment-likers', [
            'comment' => $comment,
            'likers' => $likers,
            'post' => $comment->post
        ]);
    }
    
    /**
     * Alias for getLikers method - returns users who liked a post.
     */
    public function getUsersWhoLiked(Post $post)
    {
        return $this->getLikers($post);
    }
    
    /**
     * Alias for getCommentLikers method - returns users who liked a comment.
     */
    public function getCommentUsersWhoLiked(Comment $comment)
    {
        return $this->getCommentLikers($comment);
    }
}
