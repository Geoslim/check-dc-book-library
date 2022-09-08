<?php

namespace Database\Seeders;

use App\Models\AccessLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        AccessLevel::create([
            'name' => 'Children',
            'min_age' => 7,
            'max_age' => 15,
            'lending_point' => 0
        ]);

        AccessLevel::create([
            'name' => 'Children Exclusive',
            'min_age' => 15,
            'max_age' => 24,
            'lending_point' => 10
        ]);

        AccessLevel::create([
            'name' => 'Youth',
            'min_age' => 15,
            'max_age' => 24,
            'lending_point' => 0
        ]);

        AccessLevel::create([
            'name' => 'Youth Exclusive',
            'min_age' => 15,
            'max_age' => 24,
            'lending_point' => 15
        ]);

        AccessLevel::create([
            'name' => 'Adult',
            'min_age' => 25,
            'max_age' => 49,
            'lending_point' => 0
        ]);

        AccessLevel::create([
            'name' => 'Adult Exclusive',
            'min_age' => 25,
            'max_age' => 49,
            'lending_point' => 20
        ]);

        AccessLevel::create([
            'name' => 'Senior',
            'min_age' => 50,
            'max_age' => null,
            'lending_point' => 0
        ]);

        AccessLevel::create([
            'name' => 'Senior Exclusive',
            'min_age' => 50,
            'max_age' => null,
            'lending_point' => 10
        ]);
    }
}
