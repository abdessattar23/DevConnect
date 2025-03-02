<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'image_url',
        'code_snippet',
        'published_date'
    ];

    protected $casts = [
        'published_date' => 'datetime'
    ];

    /**
     * Get the user that created the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get all likes for the post.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    /**
     * Get all comments for the post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }
    
    /**
     * Get all comments including replies for the post.
     */
    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }
    
    /**
     * Check if a user has liked the post.
     */
    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
    
    /**
     * Get the like count.
     */
    public function getLikeCountAttribute()
    {
        return $this->likes()->count();
    }
    
    /**
     * Get the comment count.
     */
    public function getCommentCountAttribute()
    {
        return $this->allComments()->count();
    }
}
