<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Services\AuthService;
use App\Services\RoleService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param AuthService $authService
     * @param RoleService $roleService
     * @return void
     */
    public function run(AuthService $authService, RoleService $roleService): void
    {
        //create users with different roles
        User::factory()->count(14)->create()->each(function (User $user) use ($authService, $roleService) {
            $authService->createProfile($user);
            $roleService->attachRolesToUser(
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
        $roleService->attachRolesToUser($admin, $roleIds);
    }
}
