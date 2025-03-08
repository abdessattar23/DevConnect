<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Posts extends Model
{
    use Notifiable;
    protected $fillable = [
        'user_id',
        'title',
        'image',
        'content',
        'code_snippet'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function hashtags()
    {
    return $this->belongsToMany(Hashtags::class, 'post_hashtags', 'post_id', 'hashtag_id');
    }
    public function comments()
    {
        return $this->hasMany(Comments::class,'post_id');
    }
    public function likes()
    {
        return $this->hasMany(Likes::class, 'post_id');
    }
}
