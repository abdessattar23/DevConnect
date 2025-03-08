<?php

namespace App\Models;
use App\Models\Posts;
use App\Models\Skills;
use App\Models\Comments;
use App\Models\Likes;
use App\Models\Shares;
use App\Models\Job_offers;
use App\Models\Hashtags;
use App\Models\Connections;
use App\Models\Project;
use App\Models\Certifications;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

   
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'cover',
        'bio',
        'website',
        'github_url',   
        'linkedin_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function posts()
    {
        return $this->hasMany(Posts::class);
    }
    public function skills()
    {
        return $this->belongsToMany(Skills::class,'skills_user','user_id','skill_id');
    }
    public function comments()
    {
        return $this->hasMany(Comments::class);
    }
    public function likes()
    {
        return $this->hasMany(Likes::class);
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    
    }
    public function certifications()
    {
        return $this->hasMany(Certifications::class);
    
    }

    public function shares()
    {
        return $this->hasMany(Shares::class);
    
    }
    public function job_offers()
    {
        return $this->hasMany(Job_offers::class);
    
    }
    public function hashtags()
    {
        return $this->hasMany(Hashtags::class);
    
    }
    public function connections()
    {
        return $this->hasMany(Connections::class);
    
    }
    public function sentConnections()
    {
        return $this->hasMany(Connections::class, 'source_user_id');
    }
    public function receivedConnections()
    {
        return $this->hasMany(Connections::class, 'target_user_id');
    }

    public function connectionStatus($targetUserId)
    {
        $connection = Connections::where(function ($query) use ($targetUserId) {
            $query->where('source_user_id', $this->id)
                  ->where('target_user_id', $targetUserId);
        })->orWhere(function ($query) use ($targetUserId) {
            $query->where('source_user_id', $targetUserId)
                  ->where('target_user_id', $this->id);
        })->first();

        return $connection ? $connection->status : null;
    }

    public function sentMessages()
    {
        return $this->hasMany(Messages::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Messages::class, 'receiver_id');
    }

    public function unreadMessages()
    {
        return $this->receivedMessages()->where('read', false);
    }
}
