<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    /**
     * Display a listing of connections for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get pending requests received by the user
        $pendingRequests = Connection::with('requester')
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->get();
            
        // Get all accepted connections (both sent and received)
        $connectedUsers = $user->connectedUsers()->get();
        
        return view('connections.index', compact('pendingRequests', 'connectedUsers'));
    }
    
    /**
     * Show the form for finding and connecting with new users.
     */
    public function find()
    {
        $user = Auth::user();
        
        // Get users who are not yet connected and have no pending requests
        $sentRequestUserIds = $user->sentConnectionRequests()->pluck('receiver_id')->toArray();
        $receivedRequestUserIds = $user->receivedConnectionRequests()->pluck('requester_id')->toArray();
        $excludeUserIds = array_merge([$user->id], $sentRequestUserIds, $receivedRequestUserIds);
        
        $suggestedUsers = User::whereNotIn('id', $excludeUserIds)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('connections.find', compact('suggestedUsers'));
    }
    
    /**
     * Send a connection request to another user.
     */
    public function sendRequest(User $user)
    {
        $currentUser = Auth::user();
        
        // Check if there's already a connection
        $existingConnection = Connection::where(function($query) use ($currentUser, $user) {
                $query->where('requester_id', $currentUser->id)
                      ->where('receiver_id', $user->id);
            })->orWhere(function($query) use ($currentUser, $user) {
                $query->where('requester_id', $user->id)
                      ->where('receiver_id', $currentUser->id);
            })->first();
            
        if ($existingConnection) {
            return back()->with('error', 'A connection request already exists between you and this user.');
        }
        
        // Create a new connection request
        Connection::create([
            'requester_id' => $currentUser->id,
            'receiver_id' => $user->id,
            'status' => 'pending'
        ]);
        
        return back()->with('success', 'Connection request sent successfully.');
    }
    
    /**
     * Accept a connection request.
     */
    public function acceptRequest(Connection $connection)
    {
        // Verify that the current user is the receiver of this request
        if (Auth::id() !== $connection->receiver_id) {
            return back()->with('error', 'You are not authorized to accept this request.');
        }
        
        $connection->update(['status' => 'accepted']);
        
        return back()->with('success', 'Connection request accepted.');
    }
    
    /**
     * Decline a connection request.
     */
    public function declineRequest(Connection $connection)
    {
        // Verify that the current user is the receiver of this request
        if (Auth::id() !== $connection->receiver_id) {
            return back()->with('error', 'You are not authorized to decline this request.');
        }
        
        $connection->update(['status' => 'declined']);
        
        return back()->with('success', 'Connection request declined.');
    }
    
    /**
     * Remove an existing connection.
     */
    public function removeConnection(Connection $connection)
    {
        // Verify that the current user is part of this connection
        if (Auth::id() !== $connection->requester_id && Auth::id() !== $connection->receiver_id) {
            return back()->with('error', 'You are not authorized to remove this connection.');
        }
        
        $connection->delete();
        
        return back()->with('success', 'Connection removed.');
    }
}
