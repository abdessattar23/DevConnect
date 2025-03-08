<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use App\Models\User;
use App\Models\Connections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $connections = Connections::where(function($query) use ($user) {
            $query->where('source_user_id', $user->id)
                  ->orWhere('target_user_id', $user->id);
        })
        ->where('status', 'accepted')
        ->get();

        $connectedUsers = collect();
        foreach($connections as $connection) {
            $connectedUser = $connection->source_user_id === $user->id 
                ? User::find($connection->target_user_id)
                : User::find($connection->source_user_id);
            $connectedUsers->push($connectedUser);
        }

        return view('messages.index', compact('connectedUsers'));
    }

    public function show($userId)
    {
        $currentUser = Auth::user();
        $otherUser = User::findOrFail($userId);

        // Verify connection exists
        $isConnected = Connections::where(function($query) use ($currentUser, $userId) {
            $query->where(function($q) use ($currentUser, $userId) {
                $q->where('source_user_id', $currentUser->id)
                  ->where('target_user_id', $userId);
            })->orWhere(function($q) use ($currentUser, $userId) {
                $q->where('source_user_id', $userId)
                  ->where('target_user_id', $currentUser->id);
            });
        })
        ->where('status', 'accepted')
        ->exists();

        if (!$isConnected) {
            return redirect()->route('messages.index')
                           ->with('error', 'You can only message users you are connected with.');
        }

        $messages = Messages::where(function($query) use ($currentUser, $userId) {
            $query->where(function($q) use ($currentUser, $userId) {
                $q->where('sender_id', $currentUser->id)
                  ->where('receiver_id', $userId);
            })->orWhere(function($q) use ($currentUser, $userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $currentUser->id);
            });
        })
        ->orderBy('sent_at', 'asc')
        ->get();

        return view('messages.show', compact('messages', 'otherUser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string'
        ]);

        $message = Messages::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'sent_at' => now(),
            'read' => false
        ]);

        return response()->json($message);
    }

    public function markAsRead($messageId)
    {
        $message = Messages::findOrFail($messageId);
        if ($message->receiver_id === Auth::id()) {
            $message->update(['read' => true]);
        }
        return response()->json(['success' => true]);
    }
}