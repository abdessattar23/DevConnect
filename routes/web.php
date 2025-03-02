<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit.laravel');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update.laravel');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('post', PostController::class);
});

Route::group(['prefix'=> 'profile', 'middleware' => 'auth'], function () {
    Route::get('/', [ProfileController::class, 'show'])->name('profile');
    Route::get('/update', [ProfileController::class, 'showEditProfile'])->name('profile.edit.custom');
    Route::post('/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/cover', [ProfileController::class, 'updateCover'])->name('profile.cover');
    Route::post('/self', [ProfileController::class, 'updateProfileImage'])->name('profile.self');
    Route::get('/{id}', [ProfileController::class, 'showUserProfile'])->name('profile.user')->where('id', '[0-9]+');
});

// Connection Routes
Route::group(['prefix' => 'connections', 'middleware' => 'auth'], function () {
    Route::get('/', [ConnectionController::class, 'index'])->name('connections.index');
    Route::get('/find', [ConnectionController::class, 'find'])->name('connections.find');
    Route::post('/request/{user}', [ConnectionController::class, 'sendRequest'])->name('connections.request');
    Route::patch('/accept/{connection}', [ConnectionController::class, 'acceptRequest'])->name('connections.accept');
    Route::patch('/decline/{connection}', [ConnectionController::class, 'declineRequest'])->name('connections.decline');
    Route::delete('/remove/{connection}', [ConnectionController::class, 'removeConnection'])->name('connections.remove');
});

// Like Routes
Route::group(['prefix' => 'likes', 'middleware' => 'auth'], function () {
    Route::post('/toggle/{post}', [LikeController::class, 'toggleLike'])->name('likes.toggle');
    Route::get('/likers/{post}', [LikeController::class, 'getLikers'])->name('likes.likers');
    Route::get('/users/{post}', [LikeController::class, 'getUsersWhoLiked'])->name('likes.users');
    // Comment likes
    Route::post('/comment/toggle/{comment}', [LikeController::class, 'toggleCommentLike'])->name('likes.comment.toggle');
    Route::get('/comment/likers/{comment}', [LikeController::class, 'getCommentLikers'])->name('likes.comment.likers');
    Route::get('/comment/users/{comment}', [LikeController::class, 'getCommentUsersWhoLiked'])->name('likes.comment.users');
});

// Comment Routes
Route::group(['prefix' => 'comments', 'middleware' => 'auth'], function () {
    Route::get('/post/{post}', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/post/{post}', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/reply/{comment}', [CommentController::class, 'reply'])->name('comments.reply');
    Route::patch('/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

require __DIR__.'/auth.php';
