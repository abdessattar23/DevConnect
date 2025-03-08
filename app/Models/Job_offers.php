<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Job_offers extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
