<?php

namespace App\Models;
use App\Models\User;
use App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Likes extends Model



{   
    use Notifiable;

    protected $fillable = [
        'user_id',
        'post_id',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function post(){
        return $this->belongsTo(Posts::class,'post_id');
    }
}
