<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Shares extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
