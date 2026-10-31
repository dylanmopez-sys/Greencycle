<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Trees extends Model
{
    protected $fillable = [
        'user_id',
        'seed_id',
        'level',
        'health',
        'progress',
        'status',
        'next_care_at',
        'last_cared_at',
        'last_decay_at',
        'harvested_at',
    ];

    protected function casts(): array
    {
        return [
            'next_care_at' => 'datetime',
            'last_cared_at' => 'datetime',
            'last_decay_at' => 'datetime',
            'harvested_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seed(): BelongsTo
    {
        return $this->belongsTo(Seed::class);
    }

    public function activeEffects(): HasMany
    {
        return $this->hasMany(ActiveEffect::class, 'tree_id');
    }
}
