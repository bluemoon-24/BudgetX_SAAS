<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->hasRole('admin');
    }

    public function view(User $currentUser, User $targetUser): bool
    {
        return $currentUser->id === $targetUser->id || $currentUser->isAdmin() || $currentUser->hasRole('admin');
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->hasRole('admin');
    }

    public function update(User $currentUser, User $targetUser): bool
    {
        return $currentUser->id === $targetUser->id || $currentUser->isAdmin() || $currentUser->hasRole('admin');
    }

    public function delete(User $currentUser, User $targetUser): bool
    {
        return $currentUser->isAdmin() || $currentUser->hasRole('admin');
    }
}
