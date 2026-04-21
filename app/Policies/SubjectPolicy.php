<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;

class SubjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->account_type, ['admin', 'staff'], true);
    }

    public function update(User $user, Subject $subject): bool
    {
        return in_array($user->account_type, ['admin', 'staff'], true);
    }
}
