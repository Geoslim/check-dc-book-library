<?php

namespace App\Services\Admin;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;

class BookService
{
    /**
     * @param array $data
     * @return Model|Book
     */
    public function createBook(array $data): Model|Book
    {
        return Book::create($data)->refresh();
    }

    /**
     * @param Book $book
     * @param array $data
     * @return Book
     */
    public function updateBook(Book $book, array $data): Book
    {
        $book->update($data);
        return $book->refresh();
    }

    /**
     * @param Book $book
     * @param string $status
     * @return void
     */
    public function updateBookStatus(Book $book, string $status): void
    {
        $book->update(['status' => $status]);
    }

    /**
     * @param Book $book
     * @param array $authorIds
     * @return void
     */
    public function attachAuthorsToBook(Book $book, array $authorIds): void
    {
        $book->authors()->sync($authorIds);
    }

    /**
     * @param Book $book
     * @param array $planIds
     * @return void
     */
    public static function attachPlansToBook(Book $book, array $planIds): void
    {
        $book->plans()->sync($planIds);
    }

    /**
     * @param Book $book
     * @param array $accessLevelIds
     * @return void
     */
    public static function attachAccessLevelsToBook(Book $book, array $accessLevelIds): void
    {
        $book->accessLevels()->sync($accessLevelIds);
    }

    /**
     * @param Book $book
     * @param array $categoryIds
     * @return void
     */
    public static function attachCategoriesToBook(Book $book, array $categoryIds): void
    {
        $book->categories()->sync($categoryIds);
    }

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
