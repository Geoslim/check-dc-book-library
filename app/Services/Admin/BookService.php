<?php

namespace App\Services\Admin;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;

class BookService
{
    public function createBook(array $data): Model|Book
    {
        return Book::create($data);
    }

    public function updateBook(Book $book, array $data): Book
    {
        $book->update($data);
        return $book->refresh();
    }

    public function updateBookStatus(Book $book, string $status): void
    {
        $book->update(['status' => $status]);
    }

    public function attachAuthorsToBook(Book $book, array $authorIds): void
    {
        $book->authors()->sync($authorIds);
    }

    public static function attachPlansToBook(Book $book, array $planIds): void
    {
        $book->tags()->sync($planIds);
    }

    public static function attachAccessLevelsToBook(Book $book, array $accessLevelIds): void
    {
        $book->tags()->sync($accessLevelIds);
    }
}
