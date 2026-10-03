<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trees extends Model
{
    protected $fillable =[
        'user_id',
        'seed_id',
        'level',
        'health',
        'progress',
        'status',
        'next_care_at',
    ];
}
