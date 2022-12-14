<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            ConfigurationSeeder::class,
            RoleSeeder::class,
            PlanSeeder::class,
            UserSeeder::class,
            TagSeeder::class,
            CategorySeeder::class,
            AccessLevelSeeder::class,
            BookSeeder::class
        ]);
    }
}
