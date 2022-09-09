<?php

namespace App\Services\Auth;

use App\Models\User;

class RoleService
{
    /**
     * @param User $user
     * @param array $roleIds
     * @return void
     */
    public static function attachRolesToUser(User $user, array $roleIds): void
    {
        $user->roles()->sync($roleIds);
    }
}
