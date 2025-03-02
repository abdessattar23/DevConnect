<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(){
        $user = Auth::user();
        return view("profile.profile", compact("user"));
    }
    
    /**
     * Show a specific user's profile by ID
     */
    public function showUserProfile($id) {
        $profileUser = User::findOrFail($id);
        $currentUser = Auth::user();
        
        // Check if there's a connection between the users
        $connectionStatus = null;
        if ($currentUser->id !== $profileUser->id) {
            $connection = \App\Models\Connection::where(function($query) use ($currentUser, $profileUser) {
                    $query->where('requester_id', $currentUser->id)
                          ->where('receiver_id', $profileUser->id);
                })->orWhere(function($query) use ($currentUser, $profileUser) {
                    $query->where('requester_id', $profileUser->id)
                          ->where('receiver_id', $currentUser->id);
                })->first();
                
            if ($connection) {
                $connectionStatus = $connection->status;
            }
        }
        
        return view("profile.user_profile", compact('profileUser', 'connectionStatus'));
    }

    // update the profile section
    public function showEditProfile(){
        $user = Auth::user();
        return view("profile.complete", compact("user"));
    }
    // submit the profile updates
    public function updateProfile(Request $request){
        $user = Auth::user();
        $request->validate([
            "fullname" => "required",
            'bio' => 'required',
            'language' => 'required',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'website' => 'nullable|url',
        ]);
        
        $user->fullname = $request->fullname;
        $user->bio = $request->bio;
        $user->language = $request->language;
        $user->github_url = $request->github_url;
        $user->linkedin_url = $request->linkedin_url;
        $user->website = $request->website;
        
        // Handle profile picture if uploaded
        if ($request->hasFile('profile_picture')) {
            $imagePath = $request->file('profile_picture')->store('profile-images', 'public');
            $user->profile_picture = $imagePath;
        }
        
        // Handle cover picture if uploaded
        if ($request->hasFile('cover_picture')) {
            $coverPath = $request->file('cover_picture')->store('profile-covers', 'public');
            $user->cover_picture = $coverPath;
        }
        
        $user->save();
        
        return redirect()->back()->with("success", "Profile updated successfully");
    }

    // cover and profile image update
    public function updateCover(Request $request){
        $user = Auth::user();
        $imagepath = $request->file('cover_image') ? $request->file('cover_image')->store('profile-covers', 'public') : null;
        $user->cover_picture = $imagepath;
        $user->save();
        return Redirect::route('profile');
    }
    
    public function updateProfileImage(Request $request){
        $user = Auth::user();
        $imagepath = $request->file('profile_image') ? $request->file('profile_image')->store('profile-images', 'public') : null;
        $user->profile_picture = $imagepath;
        $user->save();
        return Redirect::route('profile');
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit.laravel')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
