<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function update(User $auth_user, User $user)
    {
        return $user->id === $auth_user->id;
    }

    public function delete(User $auth_user, User $user)
    {
        return $user->id === $auth_user->id;
    }
}
