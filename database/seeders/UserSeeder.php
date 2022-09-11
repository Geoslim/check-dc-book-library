<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param \App\Services\Auth\AuthService $authService
     * @return void
     */
    public function run(AuthService $authService): void
    {
        //create users with different roles
        User::factory()->count(14)->create()->each(function (User $user) use ($authService) {
            $authService->createProfile($user);
            $authService->attachRolesToUser(
                $user,
                Role::inRandomOrder()
                    ->take(2)
                    ->pluck('id')
                    ->toArray()
            );
        });

        // create an admin user
        $roleIds = Role::pluck('id')->toArray();
        $data = [
            'email' => 'admin@example.com',
            'password' => 'password',
        ];
        $admin = $authService->createUser($data);
        $authService->createProfile($admin);
        $authService->attachRolesToUser($admin, $roleIds);
    }
}
