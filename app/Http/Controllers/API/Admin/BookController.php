<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{Book\CreateBookRequest,
    Book\UpdateBookRequest,
    Book\UpdateBookStatusRequest
};
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\Admin\{BookService, CategoryService, TagService};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class BookController extends Controller
{
    public function __construct(protected BookService $bookService)
    {
    }

    public function getBooks(): AnonymousResourceCollection
    {
        return BookResource::collection(
            Book::with([
                'accessLevels',
                'authors.profile',
                'categories',
                'plans',
                'tags'
            ])->paginate()
        );
    }

    public function getBook(Book $book): JsonResponse
    {
        return $this->handleResponse($book);
    }

    /**
     * @param CreateBookRequest $request
     * @return JsonResponse
     */
    public function createBook(CreateBookRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $book = $this->bookService->createBook($data);
            $this->bookService->attachAuthorsToBook($book, $data['author_id']);
            CategoryService::attachCategoriesToBook($book, $data['category_id']);
            TagService::attachTagsToBook($book, $data['tag_id']);
            return $this->handleResponse($book);
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    /**
     * @param UpdateBookStatusRequest $request
     * @param Book $book
     * @return JsonResponse
     */
    public function updateBookStatus(UpdateBookStatusRequest $request, Book $book): JsonResponse
    {
        try {
            $book->update([
                'status' => $request->validated()['status']
            ]);
            return $this->handleResponse($book);
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    /**
     * @param UpdateBookRequest $request
     * @param Book $book
     * @return JsonResponse
     * @throws Throwable
     */
    public function updateBook(UpdateBookRequest $request, Book $book): JsonResponse
    {
        try {
            $data = $request->validated();
            DB::beginTransaction();
                $book = $this->bookService->updateBook($book, $data);
                $this->bookService->attachAuthorsToBook($book, $data['author_id']);
                CategoryService::attachCategoriesToBook($book, $data['category_id']);
                TagService::attachTagsToBook($book, $data['tag_id']);
            DB::commit();
            return $this->handleResponse($book);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fatalErrorResponse($e);
        }
    }

    /**
     * @param Book $book
     * @return JsonResponse
     */
    public function deleteBook(Book $book): JsonResponse
    {
        try {
            $book->delete();
            return $this->success('Book deleted successfully');
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    protected function handleResponse($book): JsonResponse
    {
        return $this->successResponse(
            BookResource::make(
                $book->load(
                    'accessLevels',
                    'authors.profile',
                    'categories',
                    'plans',
                    'tags'
                )
            )
        );
    }
}
