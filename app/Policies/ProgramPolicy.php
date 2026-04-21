<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;

class ProgramPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->account_type, ['admin', 'staff'], true);
    }

    public function update(User $user, Program $program): bool
    {
        return in_array($user->account_type, ['admin', 'staff'], true);
    }
}
