<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'slug' => Str::slug('admin'),
        ]);

        Role::create([
            'name' => 'Author',
            'slug' => Str::slug('author'),
        ]);

        Role::create([
            'name' => 'Reader',
            'slug' => Str::slug('reader'),
        ]);
    }
}
