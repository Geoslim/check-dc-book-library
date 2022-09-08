<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Category::create(['name' => 'Action and Adventure']);
        Category::create(['name' => 'Biographies and Autobiographies']);
        Category::create(['name' => 'Classics']);
        Category::create(['name' => 'Comic']);
        Category::create(['name' => 'Cookbooks']);
        Category::create(['name' => 'Detective and Mystery']);
        Category::create(['name' => 'Essays']);
        Category::create(['name' => 'Fantasy']);
        Category::create(['name' => 'Historical Fiction']);
        Category::create(['name' => 'History']);
        Category::create(['name' => 'Horror']);
        Category::create(['name' => 'Literary Fiction']);
        Category::create(['name' => 'Memoir']);
        Category::create(['name' => 'Romance']);
        Category::create(['name' => 'Science Fiction']);
        Category::create(['name' => 'Short Stories']);
        Category::create(['name' => 'Suspense and Thrillers']);
    }
}
