<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Connections extends Model
{
    protected $fillable = ['source_user_id','target_user_id','status','request_date'];
    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_user_id');
    }
    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
