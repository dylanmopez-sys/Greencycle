<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seed extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];

    public function trees(): HasMany
    {
        return $this->hasMany(Trees::class);
    }
}
