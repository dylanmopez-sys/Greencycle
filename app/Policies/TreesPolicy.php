<?php

namespace App\Policies;

use App\Models\Trees;
use App\Models\User;

class TreesPolicy
{
    public function view(User $user, Trees $tree): bool
    {
        return $user->id === $tree->user_id;
    }

    public function care(User $user, Trees $tree): bool
    {
        return $user->id === $tree->user_id;
    }
}