<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\likeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;
use App\Models\Connections;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Posts;
use App\Notifications\PostLiked;
use App\Notifications\CommentNotification;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [ConnectionController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/view', [ProfileController::class, 'view'])->name('profile.view');
    Route::get('/notifications', [ProfileController::class, 'notification'])->name('my.notification');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/Profile', [ProfileController::class, 'addSkills'])->name('profile.addSkills');

    Route::post('/connections/send-request', [ConnectionController::class, 'sendRequest'])->name('connections.send-request');
    Route::post('/connections/accept', [ConnectionController::class, 'acceptRequest'])->name('connections.accept');
    Route::post('/connections/reject', [ConnectionController::class, 'rejectRequest'])->name('connections.reject');

  
    Route::get('profile/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('profile/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::delete('profile/{projects}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    
    
    Route::post('/posts/{postId}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/posts/{commentId}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    Route::resource('profile/certifications', CertificationController::class);
    Route::resource('posts', PostController::class);
    
    Route::post('/posts/{post}/like', [likeController::class, 'toggleLike'])->name('posts.like');
    Route::get('/posts/{post}/check-like', [likeController::class, 'checkLike'])->name('posts.checkLike');
    
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    
    Route::get('/connections', [ConnectionController::class, 'viewConnections'])->name('connections.index');
    Route::get('/explore', [ConnectionController::class, 'exploreUsers'])->name('connections.explore');
    
    // Message routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::patch('/messages/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');
});


require __DIR__.'/auth.php';
