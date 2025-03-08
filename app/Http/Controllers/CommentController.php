<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\PostCommented;   
use App\Notifications\CommentNotification;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $post = Posts::findOrFail($postId);

        $comment = new Comments();
        $comment->user_id = Auth::id();
        $comment->post_id = $postId; 
        $comment->content = $request->input('content');
        $comment->date_commentaire = now();
        $comment->save();

        if($post->user != Auth::user()){
            $post->user->notify(new CommentNotification($post));
        }
        event(new PostCommented([
            'state' => true,
            'author' => $post->comments->last()->user->name,
            'message' => 'commented on your post',
            'content' => $post->title,
            'post_owner_id' => $post->user->id
        ]));
   
        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function destroy($commentId)
    {
        $comment = Comments::findOrFail($commentId);

        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
   
}
