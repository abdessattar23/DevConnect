<?php

namespace App\Http\Controllers;

use App\Models\Connections;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConnectionController extends Controller
{
    public function dashboard()
    {
        $receivedConnections = Connections::where('target_user_id', Auth::id())
         ->where('status', 'pending')
        ->get();
        
        $posts = Posts::paginate(5);
        return view('dashboard', compact('receivedConnections','posts'));
    }

    public function sendRequest(Request $request)
    {
        $request->validate([
            'target_user_id' => 'required|exists:users,id',
        ]);

        $targetUserId = $request->input('target_user_id');
        
        $existingConnection = Connections::where(function($query) use ($targetUserId) {
            $query->where('source_user_id', Auth::id())
                  ->where('target_user_id', $targetUserId);
        })->orWhere(function($query) use ($targetUserId) {
            $query->where('source_user_id', $targetUserId)
                  ->where('target_user_id', Auth::id());
        })->first();

        if ($existingConnection) {
            if ($existingConnection->status === 'rejected') {
                return back()->with('error', 'Unable to send connection request.');
            }
            if ($existingConnection->status === 'accepted') {
                return back()->with('error', 'You are already connected with this user.');
            }
            if ($existingConnection->status === 'pending') {
                return back()->with('error', 'A connection request is already pending.');
            }
        }

        $connection = new Connections();
        $connection->source_user_id = Auth::id();
        $connection->target_user_id = $targetUserId;
        $connection->status = 'pending';
        $connection->request_date = now();
        $connection->save();

        return back()->with('status', 'Connection request sent.');
    }

    public function acceptRequest(Request $request)
    {
        $request->validate([
            'connection_id' => 'required|exists:connections,id',
        ]);

        $connection = Connections::find($request->input('connection_id'));
        
        if ($connection->target_user_id != Auth::id()) {
            return back()->withErrors(['error' => 'Unauthorized action.']);
        }

        $connection->status = 'accepted';
        $connection->save();

        return back()->with('status', 'Connection request accepted.');
    }

    public function rejectRequest(Request $request)
    {
        $request->validate([
            'connection_id' => 'required|exists:connections,id',
        ]);

        $connection = Connections::find($request->input('connection_id'));
        
        if ($connection->target_user_id != Auth::id()) {
            return back()->withErrors(['error' => 'Unauthorized action.']);
        }

        $connection->status = 'rejected';
        $connection->save();

        return back()->with('status', 'Connection request rejected.');
    }

    public function viewConnections()
    {
        $user = Auth::user();
        
        $connections = Connections::where(function($query) use ($user) {
            $query->where('source_user_id', $user->id)
                  ->orWhere('target_user_id', $user->id);
        })
        ->where('status', 'accepted')
        ->with(['sourceUser', 'targetUser'])
        ->get()
        ->map(function($connection) use ($user) {
            return $connection->source_user_id === $user->id 
                ? $connection->targetUser 
                : $connection->sourceUser;
        });

        return view('connections.index', compact('connections'));
    }

    public function exploreUsers()
    {
        $user = Auth::user();
        
        $users = User::where('users.id', '!=', $user->id)
    ->with('skills')
    ->leftJoin('connections', function ($join) use ($user) {
        $join->on('connections.target_user_id', '=', 'users.id')
             ->where('connections.source_user_id', '=', $user->id)
             ->orOn('connections.source_user_id', '=', 'users.id')
             ->where('connections.target_user_id', '=', $user->id);
    })
    ->whereNull('connections.id')
    ->select('users.*')
    ->paginate(12);


        return view('connections.explore', compact('users'));
    }
}