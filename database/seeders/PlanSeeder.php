<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Plan::create([
            'name' => 'Free',
            'price' => 0,
            'duration' => Plan::FREEMIUM,
        ]);

        Plan::create([
            'name' => 'Bronze',
            'price' => 2000,
            'duration' => 30,
        ]);

        Plan::create([
            'name' => 'Silver',
            'price' => 4500,
            'duration' => 30,
        ]);

        Plan::create([
            'name' => 'Gold',
            'price' => 7000,
            'duration' => 30,
        ]);
    }
}
