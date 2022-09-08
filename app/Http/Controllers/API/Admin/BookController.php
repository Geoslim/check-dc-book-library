<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{
    Book\CreateBookRequest,
    Book\UpdateBookRequest,
    Book\UpdateBookStatusRequest
};
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\Admin\{BookService, CategoryService, TagService};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    public function __construct(protected BookService $bookService)
    {
    }

    public function getBooks(): AnonymousResourceCollection
    {
        return BookResource::collection(
            Book::with(['accessLevels', 'authors.profile', 'categories', 'plans', 'tags'])
                ->paginate()
        );
    }

    public function getBook(Book $book): JsonResponse
    {
        return $this->successResponse(
            BookResource::make(
                $book->load('accessLevels', 'authors.profile', 'categories', 'plans', 'tags')
            )
        );
    }

    public function createBook(CreateBookRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $book = $this->bookService->createBook($data);
            $this->bookService->attachAuthorsToBook($book, $data['author_id']);
            CategoryService::attachCategoriesToBook($book, $data['category_id']);
            TagService::attachTagsToBook($book, $data['tag_id']);
            return $this->successResponse(
                BookResource::make(
                    $book->load('accessLevels', 'authors.profile', 'categories', 'plans', 'tags')
                )
            );
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    public function updateBookStatus(UpdateBookStatusRequest $request, Book $book): JsonResponse
    {
        try {
            $book->update([
                'status' => $request->validated()['status']
            ]);
            return $this->successResponse(
                BookResource::make(
                    $book->load('accessLevels', 'authors.profile', 'categories', 'plans', 'tags')
                )
            );
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    public function updateBook(UpdateBookRequest $request, Book $book): JsonResponse
    {
        try {
            $data = $request->validated();
            $book = $this->bookService->updateBook($book, $data);
            $this->bookService->attachAuthorsToBook($book, $data['author_id']);
            CategoryService::attachCategoriesToBook($book, $data['category_id']);
            TagService::attachTagsToBook($book, $data['tag_id']);
            return $this->successResponse(
                BookResource::make(
                    $book->load('accessLevels', 'authors.profile', 'categories', 'plans', 'tags')
                )
            );
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    public function deleteBook(Book $book): JsonResponse
    {
        try {
            $book->delete();
            return $this->success('Book deleted successfully');
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }
}
