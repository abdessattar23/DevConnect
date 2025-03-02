<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $posts = Post::with(['user', 'likes', 'likes.user', 'comments' => function($query) {
                        $query->whereNull('parent_id')->latest()->limit(3);
                    }, 'comments.user', 'comments.replies', 'comments.replies.user'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
                    
        if ($request->ajax()) {
            $view = view('posts._post_list', compact('posts'))->render();
            return response()->json([
                'html' => $view,
                'nextPage' => $posts->hasMorePages() ? $posts->nextPageUrl() : null
            ]);
        }
                    
        return view('dashboard', compact('user', 'posts'));
    }
}
