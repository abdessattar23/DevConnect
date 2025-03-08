<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    public function user()
    {
        return $this->belongsToMany(User::class,'skills_user','user_id','skill_id');
    }
}
