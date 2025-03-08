<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Certifications extends Model
{
    protected $fillable = [
        'title', 'description', 'certification_date','certification_link',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
