<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'title',
        'description',
        'location',
        'contract_type',
        'offer_link',
        'date_published'
    ];

    protected $casts = [
        'date_published' => 'datetime'
    ];
}
