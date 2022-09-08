<?php

namespace App\Services\Admin;

use App\Models\Book;

class CategoryService
{
    /**
     * @param Book $book
     * @param array $categoryIds
     * @return void
     */
    public static function attachCategoriesToBook(Book $book, array $categoryIds): void
    {
        $book->categories()->sync($categoryIds);
    }
}
