<?php

namespace App\Services\Auth;

use App\Models\User;

class AuthService
{
    /**
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        $user =  User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return $user->refresh();
    }

    public function createToken($user): string
    {
        return $user->createToken('userToken')->plainTextToken;
    }

    public function createProfile($user): void
    {
        $user->profile()->create([]);
    }

    public function updateProfile(User $user, array $data): User
    {
        $user->profile()->update($data);

        return $user->refresh();
    }

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
