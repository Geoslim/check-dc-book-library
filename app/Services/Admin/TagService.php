<?php

namespace App\Services\Admin;

use App\Models\Book;

class TagService
{
    /**
     * @param Book $book
     * @param array $tagIds
     * @return void
     */
    public static function attachTagsToBook(Book $book, array $tagIds): void
    {
        $book->tags()->sync($tagIds);
    }
}
