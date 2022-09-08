<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Tag::create(['name' => 'Blockbuster']);
        Tag::create(['name' => 'Childhood']);
        Tag::create(['name' => 'Christmas']);
        Tag::create(['name' => 'Feminist']);
        Tag::create(['name' => 'Justice']);
        Tag::create(['name' => 'Murder']);
        Tag::create(['name' => 'Philosophy']);
        Tag::create(['name' => 'School']);
        Tag::create(['name' => 'Summer']);
        Tag::create(['name' => 'Villian']);
    }
}
