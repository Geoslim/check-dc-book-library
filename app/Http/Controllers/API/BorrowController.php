<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lending\BorrowRequest;
use App\Http\Resources\LendingResource;
use App\Models\Book;
use App\Models\Lending;
use App\Services\Lending\LendingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BorrowController extends Controller
{
    public function __construct(protected LendingService $lendingService)
    {
    }

    public function borrowedBooks(Request $request): AnonymousResourceCollection
    {
        return LendingResource::collection(
            Lending::whereBelongsTo($request->user())
                ->with('book')->paginate()
        );
    }

    public function activeBorrowedBooks(Request $request): AnonymousResourceCollection
    {
        return LendingResource::collection(
            Lending::whereBelongsTo($request->user())->with('book')
                ->whereNull('date_time_returned')->paginate()
        );
    }

    public function returnedBooks(Request $request): AnonymousResourceCollection
    {
        return LendingResource::collection(
            Lending::with('book')
                ->whereNotNull('date_time_returned')
                ->paginate()
        );
    }

    public function borrowBook(BorrowRequest $request): JsonResponse
    {
        try {
            $book = Book::whereId($request->input('book_id'))
                ->with(['accessLevels', 'plans'])
                ->first();
            $lending = $this->lendingService->borrowBook($request->user(), $book);
            return $this->successResponse(LendingResource::make($lending->load('book')));
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }
}
