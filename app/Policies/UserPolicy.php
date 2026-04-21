<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->account_type === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->account_type === 'admin';
    }

    public function update(User $user, User $model): bool
    {
        return $user->account_type === 'admin';
    }

    public function delete(User $user, User $model): bool
    {
        return $user->account_type === 'admin' && (int) $user->id !== (int) $model->id;
    }
}
