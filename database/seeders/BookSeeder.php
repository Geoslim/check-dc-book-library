<?php

namespace Database\Seeders;

use App\Models\{Book, Category, Plan, Tag, User};
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Book::factory()->count(10)->create()->each(function (Book $book) {
            $book->tags()->sync(Tag::inRandomOrder()->take(3)->pluck('id')->toArray());
            $book->categories()->sync(Category::inRandomOrder()->take(3)->pluck('id')->toArray());
            $book->plans()->sync(Plan::inRandomOrder()->take(3)->pluck('id')->toArray());
            $book->accessLevels()->sync(Plan::inRandomOrder()->take(3)->pluck('id')->toArray());
            $book->authors()->sync(
                User::whereHas('roles', function ($query) {
                    $query->where('slug', 'author');
                })->inRandomOrder()->take(3)->pluck('id')->toArray());
        });
    }
}
