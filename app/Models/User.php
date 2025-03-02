<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'bio',
        'profile_picture',
        'cover_picture',
        'website',
        'github_url',
        'linkedin_url',
        'language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills');
    }

    /**
     * Get all posts created by the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get connection requests sent by the user.
     */
    public function sentConnectionRequests()
    {
        return $this->hasMany(Connection::class, 'requester_id');
    }

    /**
     * Get connection requests received by the user.
     */
    public function receivedConnectionRequests()
    {
        return $this->hasMany(Connection::class, 'receiver_id');
    }

    /**
     * Get all accepted connections where the user is either the requester or the receiver.
     */
    public function connections()
    {
        return $this->sentConnectionRequests()
                    ->where('status', 'accepted')
                    ->union(
                        $this->receivedConnectionRequests()
                             ->where('status', 'accepted')
                    );
    }

    /**
     * Get all users connected to this user.
     */
    public function connectedUsers()
    {
        $sentConnections = $this->sentConnectionRequests()
                                ->where('status', 'accepted')
                                ->pluck('receiver_id')
                                ->toArray();
                                
        $receivedConnections = $this->receivedConnectionRequests()
                                   ->where('status', 'accepted')
                                   ->pluck('requester_id')
                                   ->toArray();
                                   
        $connectedUserIds = array_merge($sentConnections, $receivedConnections);
        
        return User::whereIn('id', $connectedUserIds);
    }
    
    /**
     * Get all likes created by the user.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    /**
     * Get all comments created by the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
